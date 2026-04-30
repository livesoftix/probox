<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use App\Models\ProductMaster;

class ProductController extends Controller
{
public function downloadJpg($id)
{
    $product = ProductMaster::with(['account','items','country'])->findOrFail($id);

    return view('registration_form.print_download', compact('product'));
}
    private function convertPdfToJpg($pdfPath, $imagePath)
{
    $cmd = "gs -sDEVICE=jpeg -r300 -dNOPAUSE -dBATCH -dFirstPage=1 -dLastPage=1 "
         . "-sOutputFile=\"{$imagePath}\" \"{$pdfPath}\"";

    exec($cmd, $output, $returnVar);

    return file_exists($imagePath);
}
}