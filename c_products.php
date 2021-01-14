<?php

class CProducts
{
    public function getTable()
    {
        return $this->Table;
    }

    public function setTableSize($rowNum, $columnNum)
    {
        if(!$this->checkUnsignedInt($rowNum)) return false;
        if(!$this->checkUnsignedInt($columnNum)) return false;
        if ($rowNum == 0 || $columnNum == 0) return false;        

        if ($this->maxRowIndex == -1 || $this->maxColumnIndex == -1)
        {
            return $this->createNewTable($rowNum, $columnNum);
        }
        else
        {
            return $this->resizeTable($rowNum, $columnNum);
        }
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
        $tableBefore = array_slice($this->Table, 0,$index+1);
        $tableAfter = array_slice($this->Table, $index+1);
        $this->Table = array_merge($tableBefore, $insertArray, $tableAfter);
        $this->Table = array_values($this->Table);
        return true;
    }
	
	protected function resizeTable($rowNum, $columnNum)
    {
        $oldTable = $this->Table;
        $oldMaxRowIndex = $this->maxRowIndex;
        $oldMaxColumnIndex = $this->maxColumnIndex;
        $this->resetTable();
        for ($i = 0; $i < $rowNum; ++$i)
        {
            $this->Table[$i] = array();
            for ($j = 0; $j < $columnNum; ++$j)
            {
                if ($i <= $oldMaxRowIndex && $j <= $oldMaxColumnIndex)
                {
                    $this->Table[$i][$j] = $oldTable[$i][$j];
                }
                else 
                {
                    $this->Table[$i][$j] = "";
                }
            }
        }
        $this->maxRowIndex = count($this->Table);
        $this->maxColumnIndex = count($this->Table[0]);
        return true;
    }
	
    protected function createNewTable($rowNum, $columnNum)
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

    protected function checkUnsignedInt($index)
    {
        if ($index >= 0) return true;
        return false;
    }
	
	public function setTableStyle(string $newStyle)
    {
        $this->TableStyle = $newStyle;
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

    protected $TableStyle = "border=\"1\" width=\"100%\" cellpadding=\"5\"";

    protected $Table = array();
    protected $maxRowIndex = -1;
    protected $maxColumnIndex = -1;
}

?>