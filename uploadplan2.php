<?php
require_once 'includes/dbh.inc.php';

$id = $_GET['id'];

$retPic2 = mysqli_query($conn, "SELECT * FROM imagemreferenciaplanb WHERE imgplanNumProp='" . $id . "';");

if (($retPic2) && ($retPic2->num_rows != 0)) {
    while ($rowPic2 = mysqli_fetch_array($retPic2)) {
        $picPathB = $rowPic2['imgplanPathImg'];
    }
} else {
    $picPathB = "none";
}
?>

<script>
    $(document).ready(function() {
        var elem = document.getElementById("cdnurl2").value;
        if (elem != "none") {
            // console.log(elem);
            create_imgB(elem);
        }

    });


    function create_imgB(elem) {
        var img = document.createElement('img');
        img.src = elem;
        img.classList.add("thumbnail");
        document.getElementById('image-preview2').appendChild(img);
    }
</script>

<form class="form-horizontal style-form" name="form2" method="post" enctype="multipart/form-data">
    <div class="py-4">
        <div class="row">
            <div class="col-md form-group ">
                <label class='control-label text-black'>Tomografia reprovada (do caso reprovado)<b style="color: red;">*</b></label>
                <div class="d-flex justify-content-center p-2 border rounded bg-light">
                    <div>
                        <h2 style="color: #01BD6F;" class="d-flex justify-content-center"><i class="bi bi-check-circle-fill bi-3x" id="checkfile2" hidden></i></h2>
                        <p class="uploader-conecta-button" id="widget2">
                            <input id="foto2" type="hidden" role="uploadcare-uploader" data-public-key="fe82618d53dc578231ce" data-tabs="file file gdrive dropbox" data-multiple="false" data-images-only="true" data-preview-step="true" />
                        </p>
                    </div>
                </div>

                <script>
                    var NUMBER_STORED_FILES = 0;
                    const widget2 = uploadcare.Widget("#foto2", {
                        publicKey: 'fe82618d53dc578231ce'
                    });

                    widget2.onUploadComplete(info => {

                        var filename = info.name;
                        var cdnurl = info.cdnUrl;

                        document.getElementById("filename2").value = filename;
                        document.getElementById("cdnurl2").value = cdnurl;
                        document.getElementById("checkfile2").hidden = false;
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
        <div class="row d-flex justify-content-center" id="image-preview2"> </div>
    </div>
    <div class="py-4" hidden>
        <div class="row">
            <div class="col-md form-group">
                <div class="form-group d-inline-block flex-fill">
                    <label class="control-label" style="color:black;" for="filename2">File Name</label>
                    <input class="form-control" name="filename2" id="filename2" type="text" readonly>
                </div>
                <div class="form-group d-inline-block flex-fill">
                    <label class="control-label" style="color:black;" for="cdnurl2">Cdn Url</label>
                    <input class="form-control" name="cdnurl2" id="cdnurl2" type="text" value="<?php echo $picPathB; ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" name="saveimg2" class="btn btn-outline-conecta">salvar imagem</button>
    </div>

</form>

<?php
if (isset($_POST["saveimg2"])) {

    $filename2 = addslashes($_POST["filename2"]);
    $cdnurl2 = addslashes($_POST["cdnurl2"]);

    require_once 'includes/functions.inc.php';

    uploadArquivoRefTCB($conn, $filename2, $cdnurl2, $id);
}
?>