<?php include("php/head_index.php");

require_once 'includes/dbh.inc.php';

?>
<div class="p-4">
    <div id="atm" class="atm">
        <h4>ATM</h4>
        <!--<p class="lh-base" style="text-align:justify; text-justify:initial; text-indent: 50px;">
                            No momento atual estamos com restrições da matéria prima específica do polietileno com vitamina 'E'
                            para proteses de ATM, sendo ummaterial restrito a poucos fornecedores nomundo e por motivos de devolução
                            recente de toda a importação pelo setor de Qualidade, devido ao fornecedor não estar conforme nas certificações
                            exigidas pela CPMH, diante deste imprevisto por cortinas maiores esperamos que o tempo de estabilidade seja de 3 a 4meses.
                            Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de
                            implantes seguros e eficaz, não conseguimos realizar este projeto. Mesmo assim deseja solicitar a sua proposta?
                         </p>-->
        <div class="form-group">
            <label class="form-label pt-2"><b>Tipo</b></label>
            <div class="d-block col">
                <div class="form-check form-check-inline col-md-2">
                    <input class="form-check-input" type="radio" name="radioTipoAtm" id="atmStandart" value="Standart" onclick="handleTipoAtm(this)">
                    <label class="form-check-label" for="atmStandart">Standart</label>
                </div>
                <div class="form-check form-check-inline col-md-2">
                    <input class="form-check-input" type="radio" name="radioTipoAtm" id="atmSobmedida" value="Sobmedida" onclick="handleTipoAtm(this)">
                    <label class="form-check-label" for="atmSobmedida">Sobmedida</label>
                </div>
            </div>
        </div>

        <div class="" id="atmSobmedidaField">

            <div class="form-group flex-fill px-3">
                <label class="form-label pt-2"><b>Região</b></label>
                <div class="d-block">
                    <select class="form-control" name="atmRegiao" id="atmRegiao" onchange="selectAtm()">
                        <option value="0">Selecione uma opção</option>
                        <option value="Direita">Direita</option>
                        <option value="Esquerda">Esquerda</option>
                        <option value="Bilateral">Bilateral</option>
                    </select>
                </div>
            </div>
            <div class="form-group flex-fill px-3">
                <label class="form-label pt-2"><b>Tamanho</b></label>
                <div class="d-block">
                    <select class="form-control" name="atmTamanho" id="atmTamanho" onchange="setTamanho(this)">
                        <option value="0">Selecione uma opção</option>
                        <option value="P - Até linha média (Mento)">P - Até linha média (Mento)</option>
                        <option value="M - Após linha média (Mento)">M - Após linha média (Mento)</option>
                    </select>
                </div>
            </div>
            <div class="flex-fill px-3">
                <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                    <img id="atmImg">
                </div>
            </div>

        </div>

        <div class="" id="atmStandartField">

            <div class="form-group flex-fill px-3">
                <div class="d-flex justify-content-center">
                    <div class="px-5">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_2a17c080858351e532b02bdf9968bd4a.png" alt="ATM Direito">
                    </div>
                    <div class="px-2">
                        <div class="px-2 d-flex justify-content-around">
                            <table>
                                <tbody>
                                    <tr class="d-flex justify-content-center align-items-center p-2">
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                            <div class="form-check form-check-inline col-md-2">
                                                <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="ppp" value="ppp">
                                            </div>
                                        </td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                            <div class="form-check form-check-inline col-md-2">
                                                <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="mmp" value="mmp">
                                            </div>
                                        </td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                            <div class="form-check form-check-inline col-md-2">
                                                <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="ppm" value="ppm">
                                            </div>
                                        </td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                            <div class="form-check form-check-inline col-md-2">
                                                <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="mmm" value="mmm">
                                            </div>
                                        </td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                            <div class="form-check form-check-inline col-md-2">
                                                <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="ppg" value="ppg">
                                            </div>
                                        </td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;" class="d-flex justify-content-center">
                                            <div class="form-check form-check-inline col-md-2">
                                                <input class="p-1 form-check-input" type="radio" name="escolhadireito" id="mmg" value="mmg">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="d-flex justify-content-center align-items-center p-2">
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                    </tr>
                                    <tr class="d-flex justify-content-center align-items-center p-2">
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">P</td>
                                        <td style="width: 100px; height: 40px; text-align: center; border-right: 2px solid #000;">M</td>
                                    </tr>
                                    <tr class="d-flex justify-content-center align-items-center p-2">
                                        <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">P</td>
                                        <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">P</td>
                                        <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">M</td>
                                        <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">M</td>
                                        <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">G</td>
                                        <td style="width: 100px; height: 40px; text-align: center;border-right: 2px solid #000;">G</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-group flex-fill px-3">
                <label class="form-label pt-2"><b>Tamanho</b></label>
                <div class="d-block">
                    <select class="form-control" name="atmTamanho" id="atmTamanho" onchange="setTamanho(this)">
                        <option value="0">Selecione uma opção</option>
                        <option value="P - Até linha média (Mento)">P - Até linha média (Mento)</option>
                        <option value="M - Após linha média (Mento)">M - Após linha média (Mento)</option>
                    </select>
                </div>
            </div>
            <div class="flex-fill px-3 ">
                <div class="d-flex justify-content-center align-items-center p-3" style="width: max-content; height: fit-content;">
                    <img id="atmImg">
                </div>
            </div>

        </div>
        <hr style="border: 1px #ee7624 solid;">
    </div>

</div>