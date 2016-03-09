  function confirmaction(event, string){
     
    
    var c= confirm(string);
    
  if(!c){
  event.preventDefault();
  return false;
  }
  
   
}

//function removeParent(fg){
//   
//  
//  if(confirm('Wollen Sie diesen Rehaschein wirklich löschen?')){
//        
//        fg.parentNode.parentNode.remove();
//        
//   
//    }
//    
//};
//
//
//
//// setup an "add a tag" link
//var $addLink = $('<div class="form-group "><div class="col-sm-10 col-sm-push-2"><a href="#" class="add_link"><button class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Rehaschein hinzufügen</button></a></div></div>');
//var $newLinkLi = $('<div></div>').append($addLink);
//
//jQuery(document).ready(function() {
//    // Get the div that holds the collection of tags
//   var $collectionHolder = $('div.add');
//    
//    // add the "add a tag" anchor and li to the tags ul
//    $collectionHolder.append($newLinkLi);
//    
//    // count the current form inputs we have (e.g. 2), use that as the new
//    // index when inserting a new item (e.g. 2)
//    $collectionHolder.data('index', $collectionHolder.find(':input').length);
//    
//    $addLink.on('click', function(e) {
//        // prevent the link from creating a "#" on the URL
//        e.preventDefault();
//        
//        // add a new tag form (see code block below)
//        addForm($collectionHolder, $newLinkLi);
//    });
//    
//    
//});
//
//function addForm($collectionHolder, $newLinkLi) {
//    // Get the data-prototype explained earlier
//    var prototype = $collectionHolder.data('prototype');
//    
//    // get the new index
//    var index = $collectionHolder.data('index');
//    
//    // Replace '$$name$$' in the prototype's HTML to
//    // instead be a number based on how many items we have
//    var newForm = prototype.replace(/__name__/g, index);
//    
//    // increase the index with one for the next item
//    $collectionHolder.data('index', index + 1);
//    
//    // Display the form in the page in an li, before the "Add a tag" link li
//    var $newFormLi = $('<div></div>').append(newForm);
//    
//   
//    $newLinkLi.before($newFormLi);
//    
//    
//    
//    
//}

jQuery(function($) {
    $(document).on('click', '.btn-add[data-target]', function(event) {

        var collectionHolder = $('#' + $(this).attr('data-target'));

        if (!collectionHolder.attr('data-counter')) {
            collectionHolder.attr('data-counter', collectionHolder.children().length);
        }

        var prototype = collectionHolder.attr('data-prototype');
        var form = prototype.replace(/__name__/g, collectionHolder.attr('data-counter'));

        collectionHolder.attr('data-counter', Number(collectionHolder.attr('data-counter')) + 1);
        collectionHolder.append(form);

        event && event.preventDefault();
    });

    $(document).on('click', '.btn-remove[data-related]', function(event) {
        
        
        if(confirm('Sind Sie sich sicher, dass Sie dieses Feld löschen wollen?')){
        var name = $(this).attr('data-related');
        $('*[data-content="'+name+'"]').remove();

        event && event.preventDefault();
    }
    });
});