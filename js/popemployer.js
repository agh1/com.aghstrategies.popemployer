CRM.$(function($) {

  var employerEdit = function() {
    $employer.show();
    $clickToEdit.detach();
  };

  if( $('input#current_employer').length > 0) {
    var $employer = $('input#current_employer');
    var $clickToEdit = $('<span></span>', {
      class: "popemployer-hidden-edit",
      style: "cursor: pointer",
    });
    $clickToEdit.click(employerEdit);

    var first = true;
    $('#crm-container input[name^="email-"]').each( function() {
      var $emailField = $(this);

      if (first) {
        var waitToSearch = setTimeout(function() {
          runSearch($('#crm-container input[name^="email-"]').val());
        }, 750);
        first = false;
      }

      $emailField.bind('change keyup', function() {
        clearTimeout(waitToSearch);
        waitToSearch = setTimeout(function() {
          runSearch($emailField.val());
        }, 750);
      });
    });
  }

  function runSearch(email) {
    if (email.search("@") >= 0 && email.lastIndexOf(".") > email.search("@")) {
      CRM.api3('Popemployer', 'get', {
        "email": email,
      }).done(function(result) {
        if (result.result === true) {
          $employer.show();
          $clickToEdit.detach();
        }
        else {
          $employer.val(result.result);
          $clickToEdit.text(result.result+' (click to edit)');
          $employer.hide().after($clickToEdit);
        }
      });
    }
  }
});
