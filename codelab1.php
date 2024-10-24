<?php
        function segitigaSamaSisi($tinggi) {
            echo "<pre>";
            for($a = 1; $a <= $tinggi; $a++) {
                for($b = 1; $b <= $tinggi - $a; $b++) {
                    echo " ";
                }
                for($c = 1; $c <= $a * 2 - 1; $c++) {
                    echo "*";
                }
                echo "\n";
            }
            echo "</pre>";
        }

        segitigaSamaSisi(5);
?>

<?php
        function segitigaSamaSisiTerbalik($tinggi) {
            echo "<pre>";
            for($a = $tinggi; $a >= 1; $a--) {
                for($b = 1; $b <= $tinggi - $a; $b++) {
                    echo " ";
                }
                for($c = 1; $c <= $a * 2 - 1; $c++) {
                    echo "*";
                }
                echo "\n";
            }
            echo "</pre>";
        }

        segitigaSamaSisiTerbalik(5);
?>
