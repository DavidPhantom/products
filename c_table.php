<?php

class CTable
{
    public function getTable()
    {
        return $this->Table;
    }

    public function setTableSize($rowNum, $columnNum)
    {
        if(!$this->checkUnsignedInt($rowNum)) return false;
        if(!$this->checkUnsignedInt($columnNum)) return false;   

        return $this->createNewTable($rowNum, $columnNum);
    }
	
	private function createNewTable($rowNum, $columnNum)
    {
        for ($i = 0; $i < $rowNum; ++$i)
        {
            $this->Table[$i] = array();
            for ($j = 0; $j < $columnNum; ++$j)
            {
                $this->Table[$i][$j] = "";
            }
        }
        $this->maxRowIndex = $rowNum;
        $this->maxColumnIndex = $columnNum;
        return true;
    }
  
    public function fillCell($data, $rowIndex, $columnIndex)
    {
        if(!$this->checkUnsignedInt($rowIndex)) return false;
        if(!$this->checkUnsignedInt($columnIndex)) return false;
        if ($rowIndex > $this->maxRowIndex) return false;
        if ($columnIndex > $this->maxColumnIndex) return false;

        $this->Table[$rowIndex][$columnIndex] = $data;
    }

	public function pushRowAfterIndex($index)
    {
        $sliceIndex = $index + 1;
        if(!$this->checkUnsignedInt($sliceIndex)) return false;
        if ($sliceIndex > $this->maxRowIndex) return false;

        $insertArray;
        for ($j = 0; $j < $this->maxColumnIndex; ++$j)
        {
            $insertArray[0][$j] = "";
        }
        $this->maxRowIndex++;
        $tableBefore = array_slice($this->Table, 0, $index+1);
        $tableAfter = array_slice($this->Table, $index+1);
        $this->Table = array_merge($tableBefore, $insertArray, $tableAfter);
        $this->Table = array_values($this->Table);
        return true;
    }
	
	public function printTable()
    {
        echo "<table ".$this->TableStyle."";
        for ($i = 0; $i < $this->maxRowIndex; ++$i)
        {
            echo "<tr>";
            for ($j = 0; $j < $this->maxColumnIndex; ++$j)
            {
                echo "<th>".$this->Table[$i][$j]."</th>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    
    private function checkUnsignedInt($index)
    {
        if ($index >= 0) return true;
        return false;
    } 

    private $TableStyle = "border=\"1\" width=\"100%\" cellpadding=\"5\"";

    private $Table = array();
    private $maxRowIndex = -1;
    private $maxColumnIndex = -1;
}

?>