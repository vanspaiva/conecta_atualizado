<form class="form-horizontal style-form" action="includes/updateplanform1.inc.php" method="post" enctype="multipart/form-data">
    <div class="form-row" hidden>
        <div class="form-group col-md">
            <label class="form-label text-black" for="propid">Prop ID</label>
            <input type="number" class="form-control" id="propid" name="propid" value="<?php echo $row['propId']; ?>" required readonly>
            <small class="text-muted">ID não é editável</small>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md">
            <label class="form-label text-black" for="dataex"><b>Data Exame</b></label>
            <input type="date" class="form-control" id="dataex" name="dataex">
        </div>
    </div>
    <div class="form-row">
        <label class="form-label text-black"><b>Está faltando algum arquivo?</b></label>
        <div class="form-group col-md d-flex justify-content-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" name="radioCheck" type="radio" id="simCheck" value="sim" onclick="openArquivosFaltantes(this)">
                <label class="form-check-label" for="simCheck">Sim</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" name="radioCheck" type="radio" id="naoCheck" value="nao" onclick="openArquivosFaltantes(this)">
                <label class="form-check-label" for="naoCheck">Não</label>
            </div>
        </div>
    </div>
    <script>
        function openArquivosFaltantes(elem) {
            var arquivosInput = document.querySelector('.selectArquivos1');
            switch (elem.value) {
                case "sim":
                    arquivosInput.hidden = false;
                    break;

                case "nao":
                    arquivosInput.hidden = true;
                    document.getElementById("tcCheck1").checked = false;
                    document.getElementById("laudoCheck1").checked = false;
                    document.getElementById("modeloCheck1").checked = false;
                    document.getElementById("imagemCheck1").checked = false;
                    break;

                default:
                    break;
            }
        }
    </script>
    <div class="form-row selectArquivos1" hidden>
        <label class="form-label text-black"><b>Selecione os arquivos para reenviar</b></label>
        <div class="form-group col-md d-flex justify-content-start">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="arquivo1" id="tcCheck1" value="tc">
                <label class="form-check-label" for="tcCheck1">TC</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="arquivo2" id="laudoCheck1" value="laudo">
                <label class="form-check-label" for="laudoCheck1">Laudo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="arquivo3" id="modeloCheck1" value="modelo">
                <label class="form-check-label" for="modeloCheck1">Modelo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="arquivo4" id="imagemCheck1" value="imagem">
                <label class="form-check-label" for="imagemCheck1">Imagens</label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" name="update" class="btn btn-primary">Salvar</button>
    </div>
</form>