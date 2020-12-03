
$(document).ready(function() {
    $('#personBlueprint input').each(function() {
        $(this).prop("disabled", true);
    });
});
$('.newPerson').click(function() {
    const persons = $('#persons');
    const index = bwregistration_findMaxIndex();
    const newIndex = index + 1;

    const html = $('#personBlueprint').html();
    const newHtml = html.replace(/###index###/g, newIndex);
    const domElements = $(newHtml);
    domElements.find('input').each(function() {
        $(this).prop("disabled", false);
    });
    persons.append(domElements);

    const personAmount = persons.children().length;
    const maxPersonAmount = Number(persons.attr("data-max-persons"));
    if(personAmount >= maxPersonAmount) {
        $(this).fadeOut();
    }
    bwregistration_updateSlots();
    bwregistration_resizeParent();
    return false;
});

$('#persons').on('click', '.person .remove', function() {
    const newPerson = $('#personsContainer .newPerson');
    const person = $(this).closest('.person');

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
    const persons = $('#persons');
    let maxIndex = 0;
    persons.find('.person').each(function() {
        const index = Number($(this).attr("data-index"));
        if(index > maxIndex) {
            maxIndex = index;
        }
    });
    return maxIndex;
}

function bwregistration_updateSlots() {
    const persons = $('#persons').children().length;
    $('#slots .slot').each(function() {
        const seats = Number($(this).attr("data-free-seats"));
        const checkbox = $(this).find('input[type="radio"]');
        if(seats < persons) {
            checkbox.prop("disabled", true);
        } else {
            checkbox.prop("disabled", false);
        }
    });
}