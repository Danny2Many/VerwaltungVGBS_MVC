  function confirmaction(event, string){
     
    
    var c= confirm(string);
    
  if(!c){
  event.preventDefault();
  return false;
  }
  
   
}

function removeParent(fg){
   
  
  if(confirm('Wollen Sie diesen Rehaschein wirklich löschen?')){
        
        fg.parentNode.parentNode.remove();
        
   
    }
    
};



// setup an "add a tag" link
var $addRehabLink = $('<div class="form-group "><div class="col-sm-10 col-sm-push-2"><a href="#" class="add_rehab_link"><button class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Rehaschein hinzufügen</button></a></div></div>');
var $newLinkLi = $('<div></div>').append($addRehabLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
   var $collectionHolder = $('div.rehab');
    
    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);
    
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    
    $addRehabLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        
        // add a new tag form (see code block below)
        addRehabForm($collectionHolder, $newLinkLi);
    });
    
    
});

function addRehabForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');
    
    // get the new index
    var index = $collectionHolder.data('index');
    
    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);
    
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);
    
    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div></div>').append(newForm);
    
   
    $newLinkLi.before($newFormLi);
    
    
    
    
}