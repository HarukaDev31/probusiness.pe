$(document).ready(function () {
  const iSetinitialCountry = "pe";
  $("#txt-celular").intlTelInput({
    initialCountry: iSetinitialCountry,
    separateDialCode: true,
    //onlyCountries: ["pe", "mx", "ar", "ec", "ve", "cl", "br", "bo", "co", "py", "py", "uy", "pa", "sv", "hn", "ni", "cr", "cu", "pr", "gt"],
  });
});