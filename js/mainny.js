//FEEDBACK JS OG ANIMATION
//JQUERY FUNKTION DER FINDER ALLE NAMES I GIVEN FORM, OG BEHANDLER DET MED AJAX SOM SENDER DET VIDERE.
$(document).ready(function () {
    $('.feedbackform').on('submit', function () {
        var that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};

        that.find('[name]').each(function (index, value) {
            var that = $(this),
                name = that.attr('name'),
                value = that.val();
                data[name] = value;
        });

        $.ajax({
            url: url,
            type: type,
            data: $(this).serializeArray(),
            success: function (response) {
                console.log(response);
            }
        });
        return false;
    });
});

$(document).ready(function () {
    $('.btnfeedback').click(function () {
        var textareavalue = $(".kommentarfelt").val();
        var isorderapproved = $("#isorderapproved").val();

        //KOMMENTARFELTET ER TOMT, DER ER ALTSÅ INGEN KOMMENTARER AT INDSENDE.
        if(textareavalue == "") {
          swal({
            title: "Kommentarfelt er tomt!",
            text: "Indsæt en kommentar og prøv igen!",
            icon: "warning",
            button: "Prøv igen!",
          }); 
        
          //HENTER HTML VALUE, ER ORDREN GODKENDT? HVIS JA, SÅ KAN DU IKKE INDSENDE FLERE KOMMENTARER. DET ER ALTSÅ IKKE MULIGT AT AFVISE PRODUKTBILLEDER LÆNGERE.
        } else if(isorderapproved != "") {
          swal({
            title: "Ordren er allerede godkendt!",
            text: "Ordren er godkendt, det er defor ikke muligt at ændre ordren!",
            icon: "warning",
            button: "OK!",
          }); 

        //HVIS INGEN AF OVERSTÅENDE IFSTATEMENTS ER GÆLDENDE, SÅ SUBMIT FORM SÅ AJAX KAN SENDE VÆRDIEN TIL PHP.
        } else {
            swal({
                title: "Er du sikker?",
                text: "Hvis du trykker OK, sendes billedet tilbage til efterbehandling!",
                icon: "success",
                buttons: true,
                dangerMode: true,
              })
              .then((efterbehandling) => {
                if (efterbehandling) {
                  //GEM GAMMEL ORDRESTATUS.
                  $(".feedbackform").submit();  
                  $("#hideordreafvist").hide();
                  $("#hidemanglergodkendelse").hide();
                  $("#hidegodkendt").hide();
                  
                  //VIS DEN NYE ORDRESTATUS.
                  $("#afvist").html("Ordre afvist. Du modtager en email/sms når dine billeder er færdig behandlet!");
                  swal("Poof! Billedet er sendt til efterbehandling!", { 
                    icon: "success",
                  });
                } else {
                  swal("Billedet er ikke sendt til efterbehandling!", {
                    icon: "warning",

                  }
                  );
                }
              });

        }
    
    });
});

// ------------------------------------------------------------
//GODKEND KNAP JS OG ANIMATIONN
//JQUERY FUNKTION DER FINDER ALLE NAMES I GIVEN FORM, OG BEHANDLER DET MED AJAX SOM SENDER DET VIDERE.
$(document).ready(function () {
    $('#godkendform').on('submit', function () {
        var that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};

        that.find('[name]').each(function (index, value) {
            var that = $(this),
                name = that.attr('name'),
                value = that.val();
                data[name] = value;
        });

        $.ajax({
            url: url,
            type: type,
            data: $(this).serializeArray(),
            success: function (response) {
                console.log(response);
            }
        });

        return false;
    });

});

$(document).ready(function () {
    $('#godkendbtn').click(function () {
        //VARIABLE DER TJEKKER OM DER BOGSTAVER I TEKSTFELT.
        var textareavalue = $("textarea.form-control").val();
        //VARIABLE DER TJEKKER OM ORDREN HER GODKENDT.
        var isorderapproved = $("#isorderapproved").val();

        //HVIS DER STÅR TEKST I TEKSTFELTET BETYDER DET ORDREN ER AFVIST, OG DERFOR ER DET IKKE MULIGT AT GODKENDE ORDREN FØR BILLEDERNE ER EFTERBEHANDLET.
        if(textareavalue != "") {
            swal({
                title: "Ordren er afvist",
                text: "Ordren er afvist, og kan derfor ikke godkendes. Vent til afviste styles er efterbehandlet. Du modtager en SMS eller Email når ordren er færdigbehandlet!",
                icon: "warning",
                button: "OK!",
              });   

        //TJEKKER OM ORDREN ALLEREDE ER GODKENDT, HVIS DETTE ER SANDT ER DET IKKE MULIGT AT GODKENDE ORDREN IGEN.
        } else if(isorderapproved != "") {
            swal({
                title: "Ordren er allerede godkendt",
                text: "Orden er allerede godkendt, og kan derfor ikke godkendes igen!",
                icon: "warning",
                button: "OK!",
              });  

        //HVIS INGEN AF OVERSTÅENDE IFSTATEMENTS ER GÆLDENDE, ER DET MULIGT AT GODKENDE ORDREN.
        } else {
            swal({
                title: "Er du sikker?",
                text: "Hvis du trykker OK, godkendes hele ordren!",
                icon: "success",
                buttons: true,
                dangerMode: true,
              })
              .then((godkendes) => {
                if (godkendes) {
                //GEM GAMMEL ORDRESTATUS.
                  $("#godkendform").submit();
                  $("#hideordreafvist").hide();
                  $("#hidemanglergodkendelse").hide();
                  $("#hidegodkendt").hide();
                //VIS DEN NYE ORDRESTATUS.
                  $("#godkendt").html("Ordren er godkendt!");
                  setTimeout(function(){location.reload()}, 1500);
                  swal("Poof! Ordren er godkendt!", { 
                    icon: "success",
                  });
                } else {
                  swal("Ordren er ikke blevet godkendt!", {
                    icon: "warning",

                  });
                }
              });

        }
    
    });
});
