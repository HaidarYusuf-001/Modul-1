<?php
function getDisplayPreference() {
    // Contoh preferensi yang disimpan dalam session; Anda bisa menyesuaikan dengan cookies
    if (isset($_SESSION['display_preference'])) {
        return $_SESSION['display_preference'];
    }
    return "light"; // Default preference
}

function setDisplayPreference($preference) {
    $_SESSION['display_preference'] = $preference;
}
?>
