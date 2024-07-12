<?php

    // function define_button_color($tipo){
    //     if ($tipo == 'special'){
    //         echo "
    //             <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
    //                 <button class='button-back button-back-dark p-0 m-0 pt-2' style='color:#4F4F51' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
    //             </div>
    //         ";
    //     } else {
    //         echo "
    //         <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
    //             <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
    //         </div>
    //     ";
    //     }
    // }


    function define_button_color($tipo){
        if ($tipo == 'special'){
            echo "
                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                    <a class='button-back button-back-dark p-0 m-0 pt-2' style='color:#4F4F51' type='button' href='index.php'><i class='fas fa-chevron-left fa-2x'></i></a>
                </div>
            ";
        } else if ($tipo == 'orange'){
            echo "
            <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                <a class='button-back p-0 m-0 pt-2' type='button' href='index.php' style='color: #ee7624'><i class='fas fa-chevron-left fa-2x'></i></a>
            </div>
        ";
        } else {
            echo "
            <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                <a class='button-back button-back-white p-0 m-0 pt-2' type='button' href='index.php'><i class='fas fa-chevron-left fa-2x'></i></a>
            </div>
        ";
        }
    }
