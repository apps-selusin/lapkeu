CREATE VIEW `v01_barang_satuan`  AS  select `t03_barang`.`id` AS `id`,`t03_barang`.`Nama` AS `Nama`,`t02_satuan`.`Nama` AS `Satuan` from (`t03_barang` join `t02_satuan` on((`t03_barang`.`satuan_id` = `t02_satuan`.`id`))) ;