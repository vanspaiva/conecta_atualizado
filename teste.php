<?php
header("location: index");

// include_once 'includes/functions.inc.php';
// include_once 'includes/dbh.inc.php';

// $numpedido = 11396;
// $limiteHoras = valorLimiteHoras($conn, $numpedido);

// $descricao = verificarLimitesHoras($conn, $numpedido);

// echo getMultiplicadorPedido($conn, $numpedido);
// echo "<br>";

// echo valorOriginal($limiteHoras);

// echo "<br>";
// echo valorResultante($descricao, $limiteHoras);
// include_once 'includes/functions.inc.php';
// include_once 'includes/dbh.inc.php';


// $values = [
//     ['7690', 'plan'],
//     ['7713', 'plan'],
//     ['7758', 'plan'],
//     ['7757', 'plan'],
//     ['8732', 'plan'],
//     ['8735', 'plan'],
//     ['8736', 'plan'],
//     ['7759', 'plan'],
//     ['8753', 'plan'],
//     ['8752', 'plan'],
//     ['8759', 'plan'],
//     ['8750', 'plan'],
//     ['8751', 'plan'],
//     ['8790', 'plan'],
//     ['8791', 'plan'],
//     ['8781', 'plan'],
//     ['8795', 'plan'],
//     ['8809', 'plan'],
//     ['8810', 'plan'],
//     ['8812', 'plan'],
//     ['8835', 'plan'],
//     ['8836', 'plan'],
//     ['8841', 'plan'],
//     ['8849', 'plan'],
//     ['8854', 'plan'],
//     ['8876', 'plan'],
//     ['8884', 'plan'],
//     ['8857', 'plan'],
//     ['8895', 'plan'],
//     ['8886', 'plan'],
//     ['8899', 'plan'],
//     ['8900', 'plan'],
//     ['8901/9078', 'plan'],
//     ['8902', 'plan'],
//     ['8920', 'plan'],
//     ['8929', 'plan'],
//     ['8930', 'plan'],
//     ['8932', 'plan'],
//     ['8940', 'plan'],
//     ['8942', 'plan'],
//     ['8945', 'plan'],
//     ['8946', 'plan'],
//     ['8948', 'plan'],
//     ['8953', 'plan'],
//     ['8962', 'plan'],
//     ['8964', 'plan'],
//     ['8966', 'plan'],
//     ['8972', 'plan'],
//     ['8982', 'plan'],
//     ['8982', 'plan'],
//     ['8990', 'plan'],
//     ['9002', 'plan'],
//     ['8996', 'plan'],
//     ['8976', 'plan'],
//     ['9013', 'plan'],
//     ['9029', 'plan'],
//     ['9033', 'plan'],
//     ['9034', 'plan'],
//     ['9036', 'plan'],
//     ['9037', 'plan'],
//     ['9052', 'plan'],
//     ['9060', 'plan'],
//     ['9067', 'plan'],
//     ['9079', 'plan'],
//     ['9101', 'plan'],
//     ['9103', 'plan'],
//     ['9121', 'plan'],
//     ['9120', 'plan'],
//     ['9114', 'plan'],
//     ['9119', 'plan'],
//     ['9125', 'plan'],
//     ['9129', 'plan'],
//     ['9131', 'plan'],
//     ['9132', 'plan'],
//     ['9138', 'plan'],
//     ['9144', 'plan'],
//     ['9149', 'plan'],
//     ['9151', 'plan'],
//     ['9153', 'plan'],
//     ['9157', 'plan'],
//     ['9170', 'plan'],
//     ['9169', 'plan'],
//     ['9158', 'plan'],
//     ['9171', 'plan'],
//     ['9175', 'plan'],
//     ['9184', 'plan'],
//     ['9186', 'plan'],
//     ['9203', 'plan'],
//     ['9204', 'plan'],
//     ['9205', 'plan'],
//     ['9206', 'plan'],
//     ['9207', 'plan'],
//     ['9210', 'plan'],
//     ['9218', 'plan'],
//     ['9221', 'plan'],
//     ['9224', 'plan'],
//     ['9226', 'plan'],
//     ['9236', 'plan'],
//     ['9237', 'plan'],
//     ['9220', 'plan'],
//     ['9228', 'plan'],
//     ['9249', 'plan'],
//     ['9253', 'plan'],
//     ['9266', 'plan'],
//     ['9269', 'plan'],
//     ['9275', 'plan'],
//     ['9289', 'plan'],
//     ['9291', 'plan'],
//     ['9294', 'plan'],
//     ['9314', 'plan'],
//     ['9331', 'plan'],
//     ['9332', 'plan'],
//     ['9358', 'plan'],
//     ['9359', 'plan'],
//     ['9366', 'plan'],
//     ['9376', 'plan'],
//     ['9380', 'plan'],
//     ['9385', 'plan'],
//     ['9394', 'plan'],
//     ['9399', 'plan'],
//     ['9408', 'plan'],
//     ['9409', 'plan'],
//     ['9418', 'plan'],
//     ['9424', 'plan'],
//     ['9426', 'plan'],
//     ['9429', 'plan'],
//     ['9434', 'plan'],
//     ['9436', 'plan'],
//     ['9437', 'plan'],
//     ['9452', 'plan'],
//     ['9460', 'plan'],
//     ['9465', 'plan'],
//     ['9466', 'plan'],
//     ['9471', 'plan'],
//     ['9472', 'plan'],
//     ['9473', 'plan'],
//     ['9478', 'plan'],
//     ['9479', 'plan'],
//     ['9482', 'plan'],
//     ['9486', 'plan'],
//     ['9494', 'plan'],
//     ['9499', 'plan'],
//     ['9507', 'plan'],
//     ['9508', 'plan'],
//     ['9509', 'plan'],
//     ['9524', 'plan'],
//     ['9506', 'plan'],
//     ['9530', 'plan'],
//     ['9546', 'plan'],
//     ['9544', 'plan'],
//     ['9548', 'plan'],
//     ['9562', 'plan'],
//     ['9563', 'plan'],
//     ['9568', 'plan'],
//     ['9571', 'plan'],
//     ['9570', 'plan'],
//     ['9573', 'plan'],
//     ['9579', 'plan'],
//     ['9580', 'plan'],
//     ['9515', 'plan'],
//     ['9597', 'plan'],
//     ['9598', 'plan'],
//     ['9603', 'plan'],
//     ['9609', 'plan'],
//     ['9616', 'plan'],
//     ['9645', 'plan'],
//     ['9413', 'plan'],
//     ['9415', 'plan'],
//     ['9652', 'plan'],
//     ['9653', 'plan'],
//     ['9654', 'plan'],
//     ['9656', 'plan'],
//     ['9658', 'plan'],
//     ['9664', 'plan'],
//     ['9547', 'plan'],
//     ['9688', 'plan'],
//     ['9691', 'plan'],
//     ['9693', 'plan'],
//     ['9694', 'plan'],
//     ['9698', 'plan'],
//     ['9559', 'plan'],
//     ['9709', 'plan'],
//     ['9715', 'plan'],
//     ['9716', 'plan'],
//     ['9553', 'plan'],
//     ['9724', 'plan'],
//     ['9725', 'plan'],
//     ['9717', 'plan'],
//     ['9673', 'plan'],
//     ['9674', 'plan'],
//     ['9742', 'plan'],
//     ['9741', 'plan'],
//     ['9758', 'plan'],
//     ['9764', 'plan'],
//     ['9768', 'plan'],
//     ['9771', 'plan'],
//     ['9776', 'plan'],
//     ['9777', 'plan'],
//     ['9779', 'plan'],
//     ['9780', 'plan'],
//     ['9799', 'plan'],
//     ['9665', 'plan'],
//     ['9666', 'plan'],
//     ['9800', 'plan'],
//     ['9802', 'plan'],
//     ['9806', 'plan'],
//     ['9803', 'plan'],
//     ['9815', 'plan'],
//     ['9818', 'plan'],
//     ['10507', 'Lucas'],
//     ['9822', 'plan'],
//     ['9827', 'plan'],
//     ['9828', 'plan'],
//     ['9837', 'Erick'],
//     ['9839', 'plan'],
//     ['9843', 'plan'],
//     ['9852', 'plan'],
//     ['9853', 'plan'],
//     ['9854', 'plan'],
//     ['9856', 'plan'],
//     ['9864', 'plan'],
//     ['9866', 'plan'],
//     ['9859', 'plan'],
//     ['9622', 'plan'],
//     ['9875', 'plan'],
//     ['9885', 'plan'],
//     ['9890', 'plan'],
//     ['9897', 'plan'],
//     ['9898', 'plan'],
//     ['9900', 'plan'],
//     ['9908', 'plan'],
//     ['9911', 'plan'],
//     ['9914', 'plan'],
//     ['9931', 'plan'],
//     ['9934', 'plan'],
//     ['9939', 'plan'],
//     ['9943', 'Lucas'],
//     ['9948', 'plan'],
//     ['9949', 'plan'],
//     ['9955', 'plan'],
//     ['9944', 'plan'],
//     ['9969', 'plan'],
//     ['9968', 'plan'],
//     ['9952', 'plan'],
//     ['9967', 'plan'],
//     ['9963', 'plan'],
//     ['9975', 'plan'],
//     ['9976', 'plan'],
//     ['9977', 'plan'],
//     ['9980', 'plan'],
//     ['9978', 'plan'],
//     ['9979', 'plan'],
//     ['9989', 'plan'],
//     ['9990', 'plan'],
//     ['9991', 'plan'],
//     ['9992', 'plan'],
//     ['9993', 'plan'],
//     ['9994', 'plan'],
//     ['9930', 'plan'],
//     ['9623', 'plan'],
//     ['10011', 'plan'],
//     ['10014', 'plan'],
//     ['125456', 'Lucas'],
//     ['10016', 'plan'],
//     ['10057', 'plan'],
//     ['10038', 'plan'],
//     ['10055', 'plan'],
//     ['10044', 'plan'],
//     ['10046', 'plan'],
//     ['10056', 'plan'],
//     ['10123', 'plan'],
//     ['10124', 'plan'],
//     ['10079', 'plan'],
//     ['10078', 'plan'],
//     ['10130', 'plan'],
//     ['10136', 'plan'],
//     ['10148', 'plan'],
//     ['10151', 'plan'],
//     ['10169', 'plan'],
//     ['10170', 'plan'],
//     ['9982', 'plan'],
//     ['10180', 'plan'],
//     ['10181', 'plan'],
//     ['10101', 'plan'],
//     ['10195', 'plan'],
//     ['10201', 'plan'],
//     ['10207', 'plan'],
//     ['10210', 'plan'],
//     ['10212', 'plan'],
//     ['10213', 'plan'],
//     ['10215', 'plan'],
//     ['10220', 'vitor.maman'],
//     ['10216', 'plan'],
//     ['10223', 'plan'],
//     ['10076', 'plan'],
//     ['10225', 'plan'],
//     ['10227', 'plan'],
//     ['10239', 'plan'],
//     ['10246', 'plan'],
//     ['10248', 'plan'],
//     ['10256', 'plan'],
//     ['10257', 'plan'],
//     ['10259', 'plan'],
//     ['10231', 'plan'],
//     ['10264', 'plan'],
//     ['10265', 'plan'],
//     ['10269', 'plan'],
//     ['10273', 'plan'],
//     ['10275', 'plan'],
//     ['10274', 'plan'],
//     ['10277', 'plan'],
//     ['10278', 'plan'],
//     ['10285', 'plan'],
//     ['10292', 'plan'],
//     ['10312', 'plan'],
//     ['10244', 'plan'],
//     ['10320', 'plan'],
//     ['10321', 'plan'],
//     ['10322', 'Lucas'],
//     ['10301', 'plan'],
//     ['10330', 'plan'],
//     ['10325', 'plan'],
//     ['10332', 'Lucas'],
//     ['10336', 'plan'],
//     ['10343', 'plan'],
//     ['10344', 'plan'],
//     ['10302', 'plan'],
//     ['10348', 'plan'],
//     ['10359', 'Lucas'],
//     ['10367', 'plan'],
//     ['10369', 'plan'],
//     ['10370', 'plan'],
//     ['10371', 'plan'],
//     ['10373', 'plan'],
//     ['10381', 'plan'],
//     ['10391', 'plan'],
//     ['10392', 'plan'],
//     ['10397', 'plan'],
//     ['10400', 'vitor.maman'],
//     ['10401', 'plan'],
//     ['10402', 'Erick'],
//     ['10403', 'plan'],
//     ['1410', 'plan'],
//     ['10412', 'Lucas'],
//     ['10422', 'vitor.maman'],
//     ['10425', 'Eduardo'],
//     ['10424', 'vitor.maman'],
//     ['10427', 'Erick'],
//     ['10428', 'plan'],
//     ['10430', 'Lucas'],
//     ['10434', 'Lucas'],
//     ['10440', 'vitor.maman'],
//     ['10441', 'plan'],
//     ['10451', 'plan'],
//     ['10435', 'vitor.maman'],
//     ['10454', 'vitor.maman'],
//     ['10466', 'Pedro'],
//     ['10469', 'vitor.maman'],
//     ['10470', 'daniel.lima'],
//     ['10475', 'vitor.maman'],
//     ['10382', 'plan'],
//     ['10250', 'Erick'],
//     ['10443', 'plan'],
//     ['10471', 'daniel.lima'],
//     ['10476', 'Lucas'],
//     ['10429', 'Erick'],
//     ['10539', 'Lucas'],
//     ['10069', 'plan'],
//     ['10495', 'Lucas'],
//     ['10494', 'vitor.maman'],
//     ['10501', 'plan'],
//     ['10502', 'vitor.maman'],
//     ['10500', 'Erick'],
//     ['10509', 'Lucas'],
//     ['10510', 'daniel.lima'],
//     ['10377', 'Lucas'],
//     ['10508', 'vitor.maman'],
//     ['10192', 'plan'],
//     ['10361', 'plan'],
//     ['10512', 'vitor.maman'],
//     ['10521', 'Lucas'],
//     ['10523', 'Lucas'],
//     ['10524', 'daniel.lima'],
//     ['10533', 'vitor.maman'],
//     ['10534', 'Lucas'],
//     ['10535', 'Beatriz'],
//     ['10536', 'vitor.maman'],
//     ['10542', 'Erick'],
//     ['10540', 'plan'],
//     ['10543', 'Lucas'],
//     ['10546', 'vitor.maman'],
//     ['10547', 'daniel.lima'],
//     ['10551', 'Erick'],
//     ['10541', 'Lucas'],
//     ['10553', 'vitor.maman'],
//     ['10558', 'Erick'],
//     ['10569', 'Lucas'],
//     ['10568', 'daniel.lima'],
//     ['10562', 'Lucas'],
//     ['10574', 'Erick'],
//     ['10575', 'Erick'],
//     ['10576', 'vitor.maman'],
//     ['10556', 'Lucas'],
//     ['10559', 'daniel.lima'],
//     ['10528', 'vitor.maman'],
//     ['10570', 'vitor.maman'],
//     ['10580', 'vitor.maman'],
//     ['10581', 'Lucas'],
//     ['10583', 'daniel.lima'],
//     ['10591', 'Lucas'],
//     ['10594', 'vitor.maman'],
//     ['10597', 'vitor.maman'],
//     ['10596', 'vitor.maman'],
//     ['10606', 'Beatriz'],
//     ['10609', 'Erick'],
//     ['10608', 'Beatriz'],
//     ['10611', 'Lucas'],
//     ['10614', 'vitor.maman'],
//     ['10618', 'vitor.maman'],
//     ['10612', 'Erick'],
//     ['10628', 'daniel.lima'],
//     ['10635', 'Erick'],
//     ['10641', 'daniel.lima'],
//     ['10640', 'Lucas'],
//     ['10649', 'Lucas'],
//     ['', 'plan'],
//     ['10639', 'plan'],
//     ['10625', 'Beatriz'],
//     ['10656', 'daniel.lima'],
//     ['10657', 'Lucas'],
//     ['10662', 'daniel.lima'],
//     ['10665', 'daniel.lima'],
//     ['10664', 'daniel.lima'],
//     ['10672', 'Lucas'],
//     ['10669', 'Lucas'],
//     ['10675', 'Lucas'],
//     ['10677', 'vitor.maman'],
//     ['10571', 'plan'],
//     ['10668', 'plan'],
//     ['10681', 'vitor.maman'],
//     ['10666', 'daniel.lima'],
//     ['10683', 'daniel.lima'],
//     ['10689', 'daniel.lima'],
//     ['10692', 'daniel.lima'],
//     ['10693', 'Lucas'],
//     ['10694', 'Lucas'],
//     ['10659', 'Lucas'],
//     ['10696', 'daniel.lima'],
//     ['10697', 'daniel.lima'],
//     ['10701', 'daniel.lima'],
//     ['10705', 'vitor.maman'],
//     ['10706', 'vitor.maman'],
//     ['10695', 'Lucas'],
//     ['10703', 'Lucas'],
//     ['10704', 'vitor.maman'],
//     ['10709', 'plan'],
//     ['10717', 'vitor.maman'],
//     ['10718', 'daniel.lima'],
//     ['10719', 'vitor.maman'],
//     ['10674', 'daniel.lima'],
//     ['10721', 'daniel.lima'],
//     ['10729', 'vitor.maman'],
//     ['10688', 'Lucas'],
//     ['10725', 'daniel.lima'],
//     ['10734', 'daniel.lima'],
//     ['10732', 'vitor.maman'],
//     ['10738', 'malena.souza'],
//     ['10741', 'Lucas'],
//     ['10744', 'daniel.lima'],
//     ['10698', 'daniel.lima'],
//     ['10739', 'vitor.maman'],
//     ['10748', 'daniel.lima'],
//     ['10751', 'vitor.maman'],
//     ['10752', 'vitor.maman'],
//     ['10743', 'vitor.maman'],
//     ['10724', 'vitor.maman'],
//     ['10754', 'Lucas'],
//     ['10760', 'vitor.maman'],
//     ['10762', 'vitor.maman'],
//     ['10758', 'malena.souza'],
//     ['10753', 'vitor.maman'],
//     ['10763', 'malena.souza'],
//     ['10720', 'Lucas'],
//     ['10771', 'vitor.maman'],
//     ['10773', 'vitor.maman'],
//     ['10781', 'daniel.lima'],
//     ['10782', 'vitor.maman'],
//     ['10779', 'daniel.lima'],
//     ['10786', 'plan'],
//     ['10787', 'plan'],
//     ['10788', 'plan'],
//     ['10789', 'plan'],
//     ['10791', 'daniel.lima'],
//     ['10797', 'vitor.maman'],
//     ['10800', 'Lucas'],
//     ['10794', 'malena.souza'],
//     ['10804', 'daniel.lima'],
//     ['10806', 'daniel.lima'],
//     ['10799', 'daniel.lima'],
//     ['10812', 'malena.souza'],
//     ['10805', 'daniel.lima'],
//     ['10815', 'malena.souza'],
//     ['10816', 'daniel.lima'],
//     ['10824', 'daniel.lima'],
//     ['10829', 'daniel.lima'],
//     ['991071', 'plan'],
//     ['1166', 'plan'],
//     ['10836', 'vitor.maman'],
//     ['10838', 'malena.souza'],
//     ['10839', 'daniel.lima'],
//     ['10843', 'daniel.lima'],
//     ['10845', 'daniel.lima'],
//     ['10848', 'malena.souza'],
//     ['10847', 'plan'],
//     ['10854', 'plan'],
//     ['10855', 'daniel.lima'],
//     ['10857', 'malena.souza'],
//     ['10859', 'malena.souza'],
//     ['10860', 'vitor.maman'],
//     ['10862', 'vitor.maman'],
//     ['10866', 'vitor.maman'],
//     ['10873', 'vitor.maman'],
//     ['10882', 'vitor.maman'],
//     ['10889', 'malena.souza'],
//     ['10890', 'daniel.lima'],
//     ['10891', 'vitor.maman'],
//     ['10892', 'malena.souza'],
//     ['10898', 'guilherme.tome'],
//     ['10900', 'malena.souza'],
//     ['10901', 'daniel.lima'],
//     ['10902', 'malena.souza'],
//     ['10905', 'sullivan.morbeck'],
//     ['10906', 'daniel.lima'],
//     ['10903', 'daniel.lima'],
//     ['10913', 'sullivan.morbeck'],
//     ['10915', 'daniel.lima'],
//     ['10917', 'plan'],
//     ['10914', 'daniel.lima'],
//     ['10921', 'vitor.maman'],
//     ['10927', 'guilherme.tome'],
//     ['10933', 'malena.souza'],
//     ['10935', 'sullivan.morbeck'],
//     ['10937', 'vitor.maman'],
//     ['10940', 'vitor.maman'],
//     ['10943', 'malena.souza'],
//     ['10945', 'daniel.lima'],
//     ['10948', 'joao.avelar'],
//     ['10947', 'daniel.lima'],
//     ['10946', 'vitor.maman'],
//     ['10956', 'sullivan.morbeck'],
//     ['10958', 'guilherme.tome'],
//     ['10957', 'daniel.lima'],
//     ['10962', 'guilherme.tome'],
//     ['10951', 'daniel.lima'],
//     ['10966', 'guilherme.tome'],
//     ['10954', 'plan'],
//     ['10979', 'sullivan.morbeck'],
//     ['10978', 'plan'],
//     ['10977', 'guilherme.tome'],
//     ['10990', 'joao.avelar'],
//     ['10981', 'joao.avelar'],
//     ['1117', 'plan'],
//     ['10995', 'sullivan.morbeck'],
//     ['10992', 'daniel.lima'],
//     ['10998', 'guilherme.tome'],
//     ['10999', 'daniel.lima'],
//     ['11000', 'malena.souza'],
//     ['11001', 'malena.souza'],
//     ['11004', 'sullivan.morbeck'],
//     ['11007', 'joao.avelar'],
//     ['11005', 'joao.avelar'],
//     ['11008', 'vitor.maman'],
//     ['11009', 'vitor.maman'],
//     ['11011', 'vitor.maman'],
//     ['11012', 'joao.avelar'],
//     ['11017', 'guilherme.tome'],
//     ['11019', 'vitor.maman'],
//     ['11020', 'sullivan.morbeck'],
//     ['11022', 'guilherme.tome'],
//     ['11023', 'sullivan.morbeck'],
//     ['11024', 'joao.avelar'],
//     ['11025', 'joao.avelar'],
//     ['11026', 'joao.avelar'],
//     ['11029', 'malena.souza'],
//     ['11032', 'joao.avelar'],
//     ['11036', 'malena.souza'],
//     ['11028', 'vitor.maman'],
//     ['11038', 'daniel.lima'],
//     ['11031', 'sullivan.morbeck'],
//     ['11044', 'daniel.lima'],
//     ['11047', 'joao.avelar'],
//     ['11049', 'vitor.maman'],
//     ['11052', 'vitor.maman'],
//     ['11057', 'joao.avelar'],
//     ['11064', 'vitor.maman'],
//     ['11065', 'guilherme.tome'],
//     ['11067', 'malena.souza'],
//     ['11066', 'malena.souza'],
//     ['11086', 'sullivan.morbeck'],
//     ['11093', 'daniel.lima'],
//     ['11098', 'joao.avelar'],
//     ['11099', 'daniel.lima'],
//     ['11100', 'guilherme.tome'],
//     ['11101', 'joao.avelar'],
//     ['11103', 'vitor.maman'],
//     ['11104', 'sullivan.morbeck'],
//     ['11106', 'joao.avelar'],
//     ['11107', 'guilherme.tome'],
//     ['11108', 'vitor.maman'],
//     ['11109', 'guilherme.tome'],
//     ['11117', 'joao.avelar'],
//     ['11115', 'plan'],
//     ['11127', 'malena.souza'],
//     ['11128', 'malena.souza'],
//     ['11129', 'sullivan.morbeck'],
//     ['11130', 'joao.avelar'],
//     ['11131', 'plan'],
//     ['11136', 'joao.avelar'],
//     ['11137', 'vitor.maman'],
//     ['11138', 'joao.avelar'],
//     ['11140', 'guilherme.tome'],
//     ['11141', 'guilherme.tome'],
//     ['11143', 'joao.avelar'],
//     ['11144', 'malena.souza'],
//     ['11146', 'vitor.maman'],
//     ['11149', 'vitor.maman'],
//     ['11150', 'daniel.lima'],
//     ['11155', 'joao.avelar'],
//     ['11162', 'joao.avelar'],
//     ['11163', 'joao.avelar'],
//     ['11164', 'joao.avelar'],
//     ['11165', 'plan'],
//     ['11166', 'plan'],
//     ['11167', 'plan'],
//     ['11160', 'Pedro'],
//     ['11168', 'plan'],
//     ['11169', 'plan'],
//     ['11171', 'plan'],
//     ['11172', 'plan'],
//     ['11173', 'plan'],
//     ['11211', 'plan'],
//     ['11176', 'plan'],
//     ['11177', 'plan'],
//     ['11178', 'plan'],
//     ['11179', 'plan'],
//     ['11180', 'sullivan.morbeck'],
//     ['11182', 'plan'],
//     ['11183', 'plan'],
//     ['11184', 'plan'],
//     ['11185', 'plan'],
//     ['11186', 'plan'],
//     ['11187', 'Pedro'],
//     ['11188', 'plan'],
//     ['11189', 'plan'],
//     ['11190', 'plan'],
//     ['11191', 'plan'],
//     ['11192', 'plan'],
//     ['11194', 'guilherme.tome'],
//     ['11195', 'joao.avelar'],
//     ['11196', 'guilherme.tome'],
//     ['11197', 'plan'],
//     ['11202', 'daniel.lima'],
//     ['11203', 'vitor.maman'],
//     ['11204', 'joao.avelar'],
//     ['11205', 'sullivan.morbeck'],
//     ['11206', 'plan'],
//     ['11207', 'Pedro'],
//     ['11209', 'daniel.lima'],
//     ['11208', 'daniel.lima'],
//     ['11210', 'joao.avelar'],
//     ['11213', 'sullivan.morbeck'],
//     ['11218', 'vitor.maman'],
//     ['11174', 'plan'],
//     ['11181', 'plan'],
//     ['11222', 'daniel.lima'],
//     ['11225', 'guilherme.tome'],
//     ['10548', 'vitor.maman'],
//     ['11232', 'joao.avelar'],
//     ['11234', '0 Padrão'],
//     ['11261 e 11262', '0 Padrão'],
//     ['11264', 'guilherme.tome'],
//     ['11259', 'joao.avelar'],
//     ['11270', 'joao.avelar'],
//     ['11281', 'Pedro'],
//     ['11288', 'vitor.maman'],
//     ['11297', '0 Padrão']
// ];

// $values = [
//         ['11300', 'daniel.lima'],
//         ['11302', 'guilherme.tome'],
//         ['11303', 'joao.avelar'],
//         ['11305', 'pedro.franco'],
//         ['11315', 'sullivan.morbeck'],
//         ['11316', 'joao.avelar'],
//         ['11321', 'sullivan.morbeck'],
//         ['11322', 'daniel.lima'],
//         ['11327', 'joao.avelar'],
//         ['11332', 'joao.avelar'],
//         ['11339', 'plan'],
//         ['11342', 'daniel.lima'],
//         ['11346', 'guilherme.tome'],
//         ['11349', 'joao.avelar'],
//         ['11351', 'plan'],
//         ['11356', 'daniel.lima'],
//         ['11359', 'joao.avelar'],
//         ['11361', 'guilherme.tome'],
//         ['11365', 'pedro.franco'],
//         ['11372', 'joao.avelar'],
//     ];

// foreach ($values as $value) {
//     $pedNumPedido = $value[0];
//     $pedTecnico = $value[1];

//     // Query SQL para atualizar os técnicos
//     $sql = "UPDATE pedido SET pedTecnico = '$pedTecnico' WHERE pedNumPedido = '$pedNumPedido'";

//     if (mysqli_query($conn, $sql)) {
//         echo "Atualizado pedido: " . $pedNumPedido . "<br>";
//     } else {
//         echo "Stm Failed pedido: " . $pedNumPedido . "<br>";
//     }
    
// }
// mysqli_close($conn);