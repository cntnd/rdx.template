<script>
    // Achtung: die IDs enthalten einen Punkt und muessen im jQuery-Selektor
    // maskiert werden, sonst wird "theme_file" als Klasse interpretiert.
    $(document).ready(function () {
        $(".alert_remove_file").click(function (e) {
            e.preventDefault();
            const file = $(this).data("file");
            const consent = confirm("Datei '" + file + "' löschen?");
            if (consent) {
                $("#rdx\\.theme_file").val(file);
                $("#rdx\\.theme_action").val("remove");
                $("#rdx\\.theme_form").trigger("submit");
            }
        });

        $(".alert_new_file").click(function (e) {
            e.preventDefault();
            const new_file = prompt("Bitte Dateiname eingeben:");
            if (new_file === null) {
                return;
            }
            if (new_file.trim() !== "") {
                $("#rdx\\.theme_file").val(new_file.trim());
                $("#rdx\\.theme_action").val("create");
                $("#rdx\\.theme_form").trigger("submit");
            } else {
                alert("Kein Dateiname eingegeben");
            }
        });
    });
</script>
