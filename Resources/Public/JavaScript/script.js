
$(document).ready(function() {
    $('#personBlueprint input').each(function() {
        $(this).prop("disabled", true);
    });
});
$('.newPerson').click(function() {
    var persons = $('#persons');
    var index = bwregistration_findMaxIndex();
    var newIndex = index + 1;

    var html = $('#personBlueprint').html();
    var newHtml = html.replace(/###index###/g, newIndex);
    var domElements = $(newHtml);
    domElements.find('input').each(function() {
        $(this).prop("disabled", false);
    });
    persons.append(domElements);

    var personAmount = persons.children().length;
    var maxPersonAmount = Number(persons.attr("data-max-persons"));
    if(personAmount >= maxPersonAmount) {
        $(this).fadeOut();
    }
    bwregistration_updateSlots();
    bwregistration_resizeParent();
    return false;
});

$('#persons').on('click', '.person .remove', function() {
    var newPerson = $('#personsContainer .newPerson');
    var person = $(this).closest('.person');

    person.slideUp().queue(function() {
        $(this).remove();
        bwregistration_updateSlots();
        newPerson.fadeIn();
        bwregistration_resizeParent();
        $(this).dequeue();
    });
    return false;
});

function bwregistration_findMaxIndex() {
    var persons = $('#persons');
    var maxIndex = 0;
    persons.find('.person').each(function() {
        var index = Number($(this).attr("data-index"));
        if(index > maxIndex) {
            maxIndex = index;
        }
    });
    return maxIndex;
}

function bwregistration_updateSlots() {
    var persons = $('#persons').children().length;
    $('#slots .slot').each(function() {
        var seats = Number($(this).attr("data-free-seats"));
        var checkbox = $(this).find('input[type="radio"]');
        if(seats < persons) {
            checkbox.prop("disabled", true);
        } else {
            checkbox.prop("disabled", false);
        }
    });
}

// Slots auswählen
$('.slots .date').click(function() {
    if($(this).hasClass("btn-primary")) {
        return false;
    }
    var slots = $(this).closest('.slots');
    var date = $(this).attr("data-date");

    // Button anpassen
    var dates = $(this).closest('.dates');
    dates.find('.btn-primary').removeClass("btn-primary").addClass("btn-secondary");
    $(this).removeClass("btn-secondary").addClass("btn-primary");

    // Zeiten anzeigen
    var times = slots.find('.times');
    times.children().addClass("d-none");
    times.find('div[data-date="' + date + '"]').removeClass("d-none");

    // Radiobuttons deselektieren
    slots.find('input[type="radio"]').prop("checked", false);

    bwregistration_resizeParent();
    return false;
})