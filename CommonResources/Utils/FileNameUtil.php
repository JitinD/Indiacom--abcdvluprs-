<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 10/30/15
 * Time: 12:10 AM
 */

class FileNameUtil
{
    public function makeBioDataFilename($memberId, $fileExt = "")
    {
        return "{$memberId}_biodata{$fileExt}";
    }

    public function makeTempBioDataFilename($memberId, $fileExt = "")
    {
        return "{$memberId}_biodata{$fileExt}";
    }

    public function makePaperVersionFilename($paperId, $versionNumber, $fileExt = "")
    {
        return "Paper_{$paperId}v{$versionNumber}{$fileExt}";
    }

    public function makeComplianceReportFilename($paperId, $versionNumber, $fileExt = "")
    {
        return "Report_{$paperId}v{$versionNumber}{$fileExt}";
    }

    public function makeConvenerReviewCommentsFilename($paperVersionId, $fileExt = "")
    {
        return "{$paperVersionId}reviews{$fileExt}";
    }

    public function makeReviewerReviewCommentsFilename($paperVersionReviewId, $fileExt = "")
    {
        return "{$paperVersionReviewId}reviews{$fileExt}";
    }
}