<!DOCTYPE html>
<html lang="en">
<head>
  <title>File Metadata Editor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-RXf+QSDCUQs5uwRKaDoXt55jygZZm2V++WUZduaU/Ui/9EGp3f/2KZVahFZBKGH0s774sd3HmrhUy+SgOFQLVQ==" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/pdf-lib@1.5.0"></script>
  <link rel="stylesheet" href="Assets/style.css">
</head>
<body>

<div class="container">
	<div class="row">
    	<div class="col-md-6 offset-md-3">
          <h2>File Metadata Editor</h2>

            <form action="update-meta.php" method="post" enctype="multipart/form-data">
              <div class="custom-file">
                <label for="fname" class="custom-file-label">Select PDF file to upload:</label>
                <input type="file" class="custom-file-input" id="fileToUpload" accept=".pdf" name="fileToUpload" required>
              </div>
              <button type="submit" name="submit" class="btn btn-custom">UPLOAD</button>
            </form>
          
      </div>
      <div class="col-md-12">
      <h4>File Storage</h4>
      </div>
      <div class="col-md-12 files_section">
        <div class="container">
	        <div class="row">
          <?php

            // Load all files in uploads folder
            $filecount = 0;
            $fileList = glob('uploads/*');
            if (empty($fileList)) {
                echo '<div class="col-12"> No Files have been uploaded</div>';
            }else{
              foreach($fileList as $filename){
                if(is_file($filename)){
                  $tempfilename = str_replace("uploads/","", $filename);
                  // Delete any pending temporary files
                  if (strpos($tempfilename, 'temp-') === 0) {
                    unlink($filename);
                  }else{
                    $filecount = $filecount +1;
                    // Create file element
                    echo '<div class="col-2 file_el"><a href="'.$filename.'" target="_blank"><div class="file_object" title="Download"> <img src="Assets/pdficon.png" width="50px"><br>'. $tempfilename. '</div></a></div>'; 
                  }                    
                }   
              }
              if ($filecount == 0){
                echo '<div class="col-12"> No Files have been uploaded</div>';
              }
            }
            
          ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<script>
  // Bootstrap file upload fix - Update label with selected file name.
  $("#fileToUpload").on("change",function(){
    $(".custom-file-label").text($('#fileToUpload').val().replace(/^C:\\fakepath\\/i, ''));
  })
  
</script>
</html>
