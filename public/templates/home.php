<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/templates/style.css">
    <title>Chat</title>

</head>
<body>
    
    <main class="container d-flex flex-column justify-content-end bg-light" style="height: 100vh; width: 60vw">

        <div class="d-flex flex-column mb-3" style="heigh: 100%" id="main-chat">
            
        </div>
        
        <form action="javascript:void(0)" enctype="multipart/form-data" id="main-form" class="darker" style="width: 100%">
            <div class="form mb-2">

                <div class="text">
                    <label for="text" class="form-label">Message</label>
                    <textarea class="form-control mb-2" id="text" name="text" rows="3" required></textarea>
                </div>
                

                <!-- <label for="formFile" class="form-label">File Upload</label>
                <input class="form-control" type="file" name="file" id="formFile"> -->
                <div class="file">
                    <label for="formFile">
                        <i class="fa fa-paperclip fa-lg" aria-hidden="true"></i>
                    </label> 
                    <input type="file" class="form-control file-input hide" name="formFile" id="formFile">
                    <div class="filename-container hide"></div>
                    <small id="error" class="text-danger"></small>
                </div>
                

                

            </div>
            <button class="btn btn-success mb-2" type="submit">Send</button>
        </form>
        
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/compressorjs/1.0.6/compressor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script type="text/javascript" src="/templates/script.js"></script>
    
</body>
</html>