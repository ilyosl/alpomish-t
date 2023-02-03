<?php

namespace App\Services;

class SectionPageService
{
        public function uploadFile($req){

            $fileModel = new File;
            if($req->file()) {
                $fileName = time().'_'.$req->file->getClientOriginalName();
                $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
                $fileModel->name = time().'_'.$req->file->getClientOriginalName();
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();
                return back()
                    ->with('success','File has been uploaded.')
                    ->with('file', $fileName);
            }
        }
}
