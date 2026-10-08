<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContent;
use App\Support\Uploads;
use Database\Factories\ReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * An annual or impact report. "file" is the PDF, uploaded through the CMS.
 */
#[Fillable(['title', 'year', 'file'])]
class Report extends Model
{
    /** @use HasFactory<ReportFactory> */
    use FlushesSiteContent, HasFactory;

    /**
     * Public URL of the file, wherever it is stored.
     */
    protected function fileUrl(): Attribute
    {
        return Attribute::get(fn (): string => Uploads::url($this->file));
    }
}
