<?php
  //Libraries to read and write PDF metadata
  require_once('tcpdf/tcpdf.php');
  require_once('tcpdf/tcpdi.php');

  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $target_filex = $target_dir .'temp-'. basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


  // Allow only PDF file formats
  if($FileType != "pdf") {
    echo "<script> alert('Sorry, only PDF files are allowed.');location.href='index.php'</script>";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "<script> alert('Sorry, your file was not uploaded.');location.href='index.php'</script>";
    // if everything is ok, try to upload file
  }else{
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_filex)) {
      // upload has been successfull move on with the app
    } else {
      echo "<script> alert('Sorry, there was an error uploading your file.');location.href='index.php';</script>";
    }
  }

?>
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
  <script src="https://unpkg.com/pdf-lib@1.5.0"></script>
  <link rel="stylesheet" href="Assets/style.css">
</head>
<body>

  <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="UMP">File Metadata Editor</h2>
            <form action="sys_update.php">
              <div class="form-group">
                <label for="fname">File name:</label>
                <input type="text" class="form-control" id="fname" placeholder="Enter file name" name="fname">
                <input type="text" class="form-control" id="currentfname" name="currentfname">
              </div>
              <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" placeholder="Enter title" name="title">
              </div>
              <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" placeholder="Enter author" name="author">
              </div>
              <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control" id="subject" placeholder="Enter subject" name="subject">
              </div>
              <div class="form-group">
                <label for="creator">Creator:</label>
                <input type="text" class="form-control" id="creator" placeholder="Enter creator" name="creator">
              </div>
              <div class="form-group">
                <label for="keywords">Keywords:</label>
                <input type="text" class="form-control" id="keywords" placeholder="Enter keywords" name="keywords">
              </div>

              <button type="submit" class="btn btn-custom">UPDATE</button>
            </form>
            </div>
      </div>
  </div>
</body>
<script>
  const { PDFDocument } = PDFLib

  async function readPdfMetadata() {
    // Fetch temporary PDF file
    const pdfUrl = 'uploads/temp-<?php echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])) ?>';
    const pdfBytes = await fetch(pdfUrl).then((res) => res.arrayBuffer());
    const fileuploaded = 'temp-<?php echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])) ?>';

    // Load the PDF document without updating its existing metadata
    const pdfDoc = await PDFDocument.load(pdfBytes, { 
      updateMetadata: true 
    })

    // Read all available metadata fields      
    const title = pdfDoc.getTitle();
    const author = pdfDoc.getAuthor();
    const subject = pdfDoc.getSubject();
    const creator = pdfDoc.getCreator();
    const keywords = pdfDoc.getKeywords();
    
    // Auto fill relevant fields with current meta data
    $("#fname").val('<?php echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])); ?>');
    $("#currentfname").val('<?php echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])); ?>');
    $("#title").val(title);
    $("#author").val(author);
    $("#subject").val(subject);
    $("#creator").val(creator);
    $("#keywords").val(keywords);	
  }
  readPdfMetadata();
  
</script>
</html>