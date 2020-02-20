function openProductList() {  //MOSTRA A VIDEO LA FORM SELEZIONATA TRAMITE LA SELECT DI INSERIMENTO DI UN NUOVO PRODOTTO
    var tipoProdotto = document.getElementById("tipo_prodotto").value;
    var computer = document.getElementById("computer_Container");
    var memoria = document.getElementById("memoria_Container");
    var tablet = document.getElementById("tablet_Container");
    var periferica = document.getElementById("periferica_Container");
    var btn = document.getElementById("Submit_Prodotto");
    
    setDisplayNone(computer, memoria, tablet, periferica, btn);
    
    if(tipoProdotto === 'computer') {
        computer.style.display = "block";
        btn.style.display = "block";
        
    }
    else if(tipoProdotto === 'memoria') {
        memoria.style.display = "block";
        btn.style.display = "block";
    }
    else if(tipoProdotto === 'tablet') {
        tablet.style.display = "block";
        btn.style.display = "block";
    }
    else if(tipoProdotto === 'periferica') {
        periferica.style.display = "block";
        btn.style.display = "block";
    }
}

function setDisplayNone() {
    for(var i = 0; i < arguments.length; i++) {
        arguments[i].style.display = "none";
    }
}


function showOrdine(codice){    //RENDE VISIBILE L'ORDINE di CODICE 'codice'
    var open = document.getElementById("open".concat(codice));
    var ordine = document.getElementById("ordine".concat(codice));
    
    if(open.textContent == "+"){
        
        open.textContent = "-";
        
        ordine.style.visibility = "visible";
        ordine.style.height = "auto";
        ordine.style.padding = "14px";
    }
    else if(open.textContent == "-"){
        
        open.textContent = "+";
        
        ordine.style.visibility = "hidden";
        ordine.style.height = "0";
        ordine.style.padding = "0";
    }
    
}

function showErrorMessage(returnUrl, errorKindMessage, errorTypeMessage){
    var errorContainer = document.getElementById("messageContainer");
    if(errorContainer === null)
        return;

    var messageDivElem = document.getElementById("alert-container");
    if(messageDivElem !== null){
         messageDivElem.parentNode.removeChild(messageDivElem);
    }
    
    var messageDivElem = document.createElement("div");
    messageDivElem.setAttribute("class", "alert-error");
    messageDivElem.setAttribute("id", "alert-container");  

    var messageLinkElem = document.createElement("a");
    messageLinkElem.setAttribute("href", returnUrl);
    var messageImgElem = document.createElement("img");
    messageImgElem.setAttribute("src", "../css/img/Error-icon.png");
    messageImgElem.setAttribute("alt", "");
    messageLinkElem.appendChild(messageImgElem);

    var messagePElem = document.createElement("p");
    var messageStrongElem = document.createElement("strong");
    messageStrongElem.textContent = errorKindMessage;
    var messageBrElem = document.createElement("br");
    var messageTextNode = document.createTextNode(errorTypeMessage);
    messagePElem.appendChild(messageStrongElem);
    messagePElem.appendChild(messageBrElem);
    messagePElem.appendChild(messageTextNode);

    messageDivElem.appendChild(messageLinkElem);
    messageDivElem.appendChild(messagePElem);
    errorContainer.appendChild(messageDivElem);
}

function suffix(tabella){
    var suff = "";
    switch(tabella){
        case 'computer':
            suff = "_C";
            break;
        case 'memoria':
            suff = "_M";
            break;
        case 'tablet':
            suff = "_T";
            break;
        case 'periferica':
            suff = "_P";
            break;
    }
    
    return suff;
}