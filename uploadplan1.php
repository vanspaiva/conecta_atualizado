<?php
require_once 'includes/dbh.inc.php';

$id = $_GET['id'];

$retPic = mysqli_query($conn, "SELECT * FROM imagemreferenciaplana WHERE imgplanNumProp='" . $id . "';");

if (($retPic) && ($retPic->num_rows != 0)) {
    while ($rowPic = mysqli_fetch_array($retPic)) {
        $picPathA = $rowPic['imgplanPathImg'];
    }
} else {
    $picPathA = "none";
}
?>

<script>
    $(document).ready(function() {
        var elem = document.getElementById("cdnurl1").value;
        if (elem != "none") {
            // console.log(elem);
            create_imgA(elem);
        }

    });


    function create_imgA(elem) {
        var img = document.createElement('img');
        img.src = elem;
        img.classList.add("thumbnail");
        document.getElementById('image-preview1').appendChild(img);
    }
</script>

<form class="form-horizontal style-form" name="form2" method="post" enctype="multipart/form-data">
    <div class="py-4">
        <div class="row">
            <div class="col-md form-group ">
                <label class='control-label text-black'>Imagem referência (um caso bom) <b style="color: red;">*</b></label>
                <div class="d-flex justify-content-center p-2 border rounded bg-light">
                    <div>
                        <h2 style="color: #01BD6F;" class="d-flex justify-content-center"><i class="bi bi-check-circle-fill bi-3x" id="checkfile1" hidden></i></h2>
                        <p class="uploader-conecta-button" id="widget1">
                            <input id="tcfile" type="hidden" role="uploadcare-uploader" data-public-key="fe82618d53dc578231ce" data-tabs="file file gdrive dropbox" data-multiple="false" data-images-only="true" data-preview-step="true" />
                        </p>
                    </div>
                </div>

                <script>
                    var NUMBER_STORED_FILES = 0;
                    const widget1 = uploadcare.Widget("#tcfile", {
                        publicKey: 'fe82618d53dc578231ce'
                    });

                    widget1.onUploadComplete(info => {


                        var filename = info.name;


                        var cdnurl = info.cdnUrl;


                        document.getElementById("filename1").value = filename;


                        document.getElementById("cdnurl1").value = cdnurl;
                        document.getElementById("checkfile1").hidden = false;
                    });
                </script>

                <style>
                    .hovericon {
                        transition: ease all 0.2s;
                    }

                    .hovericon:hover {
                        transform: scale(0.9);
                        cursor: pointer;
                    }
                </style>
            </div>
        </div>
        <div class="row d-flex justify-content-center" id="image-preview1"> </div>
    </div>
    <div class="py-4" hidden>
        <div class="row">
            <div class="col-md form-group">
                <div class="form-group d-inline-block flex-fill">
                    <label class="control-label" style="color:black;" for="filename1">File Name</label>
                    <input class="form-control" name="filename1" id="filename1" type="text" readonly>
                </div>
                <div class="form-group d-inline-block flex-fill">
                    <label class="control-label" style="color:black;" for="cdnurl1">Cdn Url</label>
                    <input class="form-control" name="cdnurl1" id="cdnurl1" type="text" value="<?php echo $picPathA; ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" name="saveimg1" class="btn btn-outline-conecta">salvar imagem</button>
    </div>

</form>
<?php
if (isset($_POST["saveimg1"])) {

    $filename1 = addslashes($_POST["filename1"]);
    $cdnurl1 = addslashes($_POST["cdnurl1"]);

    require_once 'includes/functions.inc.php';

    uploadArquivoRefTCA($conn, $filename1, $cdnurl1, $id);
}
?>