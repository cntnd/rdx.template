<script>
    $(document).ready(function () {
        $(".alert_remove_file").click(function () {
            const file = $(this).data("file");
            const consent = confirm("Datei '" + file + "' löschen?");
            if (consent) {
                $("#rdx.theme_file").val(file);
                $("#rdx.theme_action").val("remove");
                $("#rdx.theme_form").submit();
            }
        });

        $(".alert_new_file").click(function () {
            const new_file = prompt("Bitte Dateiname eingeben:");
            if (new_file !== undefined && new_file !== "") {
                $("#rdx.theme_file").val(new_file);
                $("#rdx.theme_action").val("create");
                $("#rdx.theme_form").submit();
            } else {
                alert("Kein Dateiname eingegeben");
            }
        });
    });
</script>