<script>
    $(document).ready(function () {
        $(".alert_remove_file").click(function () {
            const file = $(this).data("file");
            const consent = confirm("Datei '" + file + "' löschen?");
            if (consent) {
                $("#cntndTemplate_file").val(file);
                $("#cntndTemplate_action").val("remove");
                $("#cntndTemplate_form").submit();
            }
        });

        $(".alert_new_file").click(function () {
            const new_file = prompt("Bitte Dateiname eingeben:");
            if (new_file !== undefined && new_file !== "") {
                $("#cntndTemplate_file").val(new_file);
                $("#cntndTemplate_action").val("create");
                $("#cntndTemplate_form").submit();
            } else {
                alert("Kein Dateiname eingegeben");
            }
        });
    });
</script>