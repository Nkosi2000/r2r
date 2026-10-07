<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContent;
use Database\Factories\ReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * An annual or impact report. "file" is a path relative to public/, e.g. reports/annual-2024.pdf.
 */
#[Fillable(['title', 'year', 'file'])]
class Report extends Model
{
    /** @use HasFactory<ReportFactory> */
    use FlushesSiteContent, HasFactory;
}
