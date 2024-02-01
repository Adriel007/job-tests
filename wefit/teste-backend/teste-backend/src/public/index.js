$(document).ready(function () {
    const enableSubmit = () => {
        if (
            (
                $("#pessoa_fisica").prop("checked") ||
                $("#pessoa_juridica").prop("checked")
            ) &&
            $("#cnpj").val() !== "" &&
            $("#cpf_responsavel").val() !== "" &&
            $("#nome").val() !== "" &&
            $("#celular").val() !== "" &&
            $("#email").val() !== "" &&
            (
                $("#confirmar_email").val() === $("#email").val()
            ) &&
            $("#termos").prop("checked") &&
            $("#cep").val() !== "" &&
            $("#logradouro").val() !== "" &&
            $("#numero").val() !== "" &&
            $("#cidade").val() !== "" &&
            $("#bairro").val() !== "" &&
            $("#estado").val() !== ""
        )
            $("#cadastrar").removeAttr("disabled");
        else
            $("#cadastrar").attr("disabled", "disabled");
    };

    $("body").on("click", enableSubmit);
    $("body").on("keyup", enableSubmit);

    $("#cnpj").mask("00.000.000/0000-00");

    $("#cpf_responsavel").mask("000.000.000-00");

    $("#celular").mask("(00) 00000-0000");

    $("#telefone").mask("(00) 0000-0000");

    $("#cep").mask("00000-000");

    enableSubmit();
});