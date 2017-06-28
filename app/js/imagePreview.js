/**
 * Created by mwz_2 on 6/26/2017.
 */
$(document).ready(function(){
    $('#file-input').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#thumb-output').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data

            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                        return function(e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                            $('#thumb-output').append(img); //append image to output element
                            $('#camera').addClass("hidden");
                            $('#upload-text').addClass("hidden");
                            $('#information-container').addClass("hidden");
                            $('#checkmark').removeClass("hidden");
                            $('#picture-input').removeClass("hidden");
                            $("#reveal-button").removeClass("hidden");
                        };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });

        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
    });

    $("#reveal-button").on("click", function()
    {
        $('#send-button').removeClass("hidden");
        $("#reveal-button").addClass("hidden");
        $(".thumb").addClass("appear");
        $("#thumb-output").removeClass("hidden");
        $("#upload").addClass("hidden");
    });
    $("#send-button").on("click", SendData);
});

function SendData()
{
    var count = $("#file-input").attr('id');
    count = count.replace("img_upload_", "");

    // make form data to submit later without refreshing page
    var data = new FormData();
    data.append('photo', $("#file-input").prop('files')[0]);
    data.append('count', count)
    data.append('message', $("#picture-input").val());

    $.ajax({
        type: 'POST',
        processData: false, // important
        contentType: false, // important
        data: data,
        url: "https://project.cmi.hr.nl/2016_2017/medialab_ns_t1/paper_trains/images/upload.php",
        success: function(jsonData){
            // after uploading, process the photo
            console.log(jsonData);
            window.location.href = "https://project.cmi.hr.nl/2016_2017/medialab_ns_t1/paper_trains/results";
        },
        error: function(jqxhr,textStatus,errorThrown) {
            console.log("Fout: Uploaden mislukt." + jqxhr + textStatus + errorThrown);
        }
    });
}