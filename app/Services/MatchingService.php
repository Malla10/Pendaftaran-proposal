<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\Dosen;
use App\Models\Recommendation;

class MatchingService
{
    /**
     * Generate rekomendasi dosen untuk proposal
     */
    public function generateRecommendations(Proposal $proposal)
    {
        $proposalKeywords = $proposal->getKeywordsArray();
        $allDosen = Dosen::all();

        $recommendations = [];

        foreach ($allDosen as $dosen) {
            $dosenKeywords = $dosen->getKeywordsArray();

            // 1. Hitung keyword score
            $keywordScore = $this->calculateKeywordScore($proposalKeywords, $dosenKeywords);

            // 2. Hitung quota penalty
            $quotaPenalty = $this->calculateQuotaPenalty($dosen);

            // 3. Final match score
            $matchScore = max(0, $keywordScore - $quotaPenalty);

            $recommendations[] = [
                'dosen' => $dosen,
                'keyword_score' => $keywordScore,
                'quota_penalty' => $quotaPenalty,
                'match_score' => $matchScore
            ];
        }

        // Sort berdasarkan match_score tertinggi
        usort($recommendations, function($a, $b) {
            return $b['match_score'] <=> $a['match_score'];
        });

        // Simpan top 5 recommendations
        $this->saveRecommendations($proposal, array_slice($recommendations, 0, 5));

        return $recommendations;
    }

    /**
     * Hitung skor kecocokan keyword (0-100)
     */
    private function calculateKeywordScore(array $proposalKeywords, array $dosenKeywords)
    {
        if (empty($proposalKeywords)) {
            return 0;
        }

        $matchCount = 0;
        $matchedKeywords = [];

        foreach ($proposalKeywords as $keyword) {
            foreach ($dosenKeywords as $dosenKeyword) {
                // Cek kecocokan exact atau partial
                if (strpos($dosenKeyword, $keyword) !== false || 
                    strpos($keyword, $dosenKeyword) !== false) {
                    if (!in_array($keyword, $matchedKeywords)) {
                        $matchCount++;
                        $matchedKeywords[] = $keyword;
                    }
                    break;
                }
            }
        }

        // Skor = (jumlah match / total keyword mahasiswa) * 100
        $score = ($matchCount / count($proposalKeywords)) * 100;

        return round($score, 2);
    }

    /**
     * Hitung penalti berdasarkan kuota (0-30)
     */
    private function calculateQuotaPenalty(Dosen $dosen)
    {
        $persentaseBeban = $dosen->getPersentaseBeban();

        // Jika beban > 80%, penalti maksimal 30%
        // Jika beban < 50%, penalti minimal 0%
        if ($persentaseBeban >= 90) {
            $penalty = 40;
        } elseif ($persentaseBeban >= 80) {
            $penalty = 30;
        } elseif ($persentaseBeban >= 70) {
            $penalty = 20;
        } elseif ($persentaseBeban >= 50) {
            $penalty = 10;
        } else {
            $penalty = 0;
        }

        return $penalty;
    }

    /**
     * Simpan rekomendasi ke database
     */
    private function saveRecommendations(Proposal $proposal, array $recommendations)
    {
        // Hapus rekomendasi lama jika ada
        Recommendation::where('proposal_id', $proposal->id)->delete();

        $rank = 1;
        foreach ($recommendations as $rec) {
            Recommendation::create([
                'proposal_id' => $proposal->id,
                'dosen_id' => $rec['dosen']->id,
                'keyword_score' => $rec['keyword_score'],
                'quota_penalty' => $rec['quota_penalty'],
                'match_score' => $rec['match_score'],
                'rank' => $rank++
            ]);
        }
    }
}