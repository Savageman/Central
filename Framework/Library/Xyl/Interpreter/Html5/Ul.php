<?php

class Hoa_Xyl_Interpreter_Html5_Ul extends Hoa_Xyl_Element_Concrete {

    public function paint ( Hoa_Stream_Interface_Out $out ) {

        $out->writeAll('  <ul' .
                       $this->getAbstractElement()->readAttributesAsString() .
                       '>' . "\n");

        foreach($this as $name => $child)
            $child->render($out);

        $out->writeAll('  </ul>' . "\n");

        return;
    }
}
