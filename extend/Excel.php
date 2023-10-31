<?php

/**
 * Created by dailinlin.
 * Date: 2019/6/4 15:29
 * for:
 */
class Excel
{

    /**
     *导入
     * @param $file
     * @return array
     */
    static public function import_excel($file){
        // 判断文件是什么格式
        $type = pathinfo($file);
        $type = strtolower($type["extension"]);

        if ($type =='xlsx') {
            $type= 'Excel2007';
        } else if ($type =='xls') {
            $type= 'Excel5';
        }

        ini_set('max_execution_time', '0');

        // 判断使用哪种格式
        $objReader =   PHPExcel_IOFactory::createReader($type);
        $objPHPExcel = $objReader->load($file);
        $sheet = $objPHPExcel->getSheet(0);
        // 取得总行数
        $highestRow = $sheet->getHighestRow();
        // 取得总列数
        $highestColumn = $sheet->getHighestColumn();
        //循环读取excel文件,读取一条,插入一条
        $data=array();
        //从第一行开始读取数据
        for($j=1;$j<=$highestRow;$j++){
            //从A列读取数据
            for($k='A';$k<=$highestColumn;$k++){
                // 读取单元格
                $data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
            }
        }
        return $data;
    }
}