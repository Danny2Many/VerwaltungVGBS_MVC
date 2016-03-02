//<::::::Mitglieder_Finanzen::::::>

function setZE(str) {
//res= option / Mitgliedsnummer / Quartal
 var res = str.split("/");
 jQuery.post("Zahlungseingang.php", {action: str});
 if(res[0] === "ja"){
     
     var idbez= res[1]+res[2]+"bez";
     var idoffen= res[1]+res[2]+"offen";
     
     var summand1= document.getElementById(idbez).innerHTML;
     var summand2= document.getElementById(idoffen).innerHTML;
     
     var summe = parseFloat(summand1) + parseFloat(summand2);
     var differenz = parseFloat(summand2) - parseFloat(summand2);
     
     document.getElementById(idbez).innerHTML= parseFloat(summe);
     document.getElementById(idoffen).innerHTML= parseFloat(differenz);
     var begin;
     var end;
     
     if(res[2] === "Q1"){
     begin=1;
     end=3;
//       document.getElementById("titel").innerHTML=res[2];  
     }
       if(res[2] === "Q2"){
     begin=4;
     end=6;
//       document.getElementById("titel").innerHTML=res[2];  
     }
       if(res[2] === "Q3"){
     begin=7;
     end=9;
//       document.getElementById("titel").innerHTML=res[2];  
     }
       if(res[2] === "Q4"){
     begin=10;
     end=12;
//       document.getElementById("titel").innerHTML=res[2];  
     }
     
    for(var i=begin; i <= end; i++){
     var summandOffen= document.getElementById("Beitr_"+ i +"_QuartMonat_offen"+ res[1]).innerHTML;
     var summandGez= document.getElementById("Beitr_"+ i +"_QuartMonat_gez"+ res[1]).innerHTML;
     
     var summe1 = parseFloat(summandOffen) + parseFloat(summandGez);
     var differenz1 = parseFloat(summandOffen) - parseFloat(summandOffen);
     
     document.getElementById("Beitr_"+ i +"_QuartMonat_offen"+ res[1]).innerHTML= parseFloat(differenz1);
     document.getElementById("Beitr_"+ i +"_QuartMonat_gez"+ res[1]).innerHTML= parseFloat(summe1);
 }
 }
 
 else if(res[0] === "nein"){
     
     var idbez= res[1]+res[2]+"bez";
     var idoffen= res[1]+res[2]+"offen";
     
     var summand1= document.getElementById(idbez).innerHTML;
     var summand2= document.getElementById(idoffen).innerHTML;
     
     var summe = parseFloat(summand1) + parseFloat(summand2);
     var differenz = parseFloat(summand1) - parseFloat(summand1);
     
     document.getElementById(idbez).innerHTML= parseFloat(differenz);
     document.getElementById(idoffen).innerHTML= parseFloat(summe);
     
        var begin;
     var end;
     
     if(res[2] === "Q1"){
     begin=1;
     end=3;
//       document.getElementById("titel").innerHTML=res[2];  
     }
      else if(res[2] === "Q2"){
     begin=4;
     end=6;
//       document.getElementById("titel").innerHTML=res[2];  
     }
      else if(res[2] === "Q3"){
     begin=7;
     end=9;
//       document.getElementById("titel").innerHTML=res[2];  
     }
      else if(res[2] === "Q4"){
     begin=10;
     end=12;
//       document.getElementById("titel").innerHTML=res[2];  
     }
     
    for(var i=begin; i <= end; i++){
     var summandOffen= document.getElementById("Beitr_"+ i +"_QuartMonat_offen"+ res[1]).innerHTML;
     var summandGez= document.getElementById("Beitr_"+ i +"_QuartMonat_gez"+ res[1]).innerHTML;
     
     var summe1 = parseFloat(summandOffen) + parseFloat(summandGez);
     var differenz1 = parseFloat(summandGez) - parseFloat(summandGez);
     
     document.getElementById("Beitr_"+ i +"_QuartMonat_offen"+ res[1]).innerHTML= parseFloat(summe1);
     document.getElementById("Beitr_"+ i +"_QuartMonat_gez"+ res[1]).innerHTML= parseFloat(differenz1);
 }
 }
 
// else if(res[0] === "geaend"){
//        jQuery.post("M_editieren_Finanzen.php", {$_SESSION['Mitgliedsnummer']: res[1]}, function(){
//            window.location="M_editieren_Finanzen.php";
//        });
//    } 
    
  

           };


//<::::::M_Finanzen_EditSpeichern::::::>
        
   var Speicher =  ["null", "null", "null", "null", "null", "null", "null", "null", "null", "null", "null", "null"];
   var Zwischenspeicher=0;
   
   // onclick gez
function save(name){
    
    var str = name.toString().split("_");
    
    var x = parseInt(str[1])-parseInt(1);

    
    
    if(Speicher[x] === "null"){
  
  
  var beitrquartmonatoffen="Beitr_"+str[1]+"_QuartMonat_offen";
  
  var zahl=parseFloat(document.forms["formSave"].elements[beitrquartmonatoffen].value.replace(",","."));
  
  Speicher[x] = zahl.toFixed(2);
document.getElementById("demo").innerHTML="onclick offen savevalue Speicher[x]:"+Speicher[x];
  
    }
}



// onclick offen - speichert Wert des Beitr__QuartMonat_offen Feldes
function savevalue(name){
   
    var str = name.toString().split("_");
    
    var beitrquartmonatoffen="Beitr_"+str[1]+"_QuartMonat_offen";
    
    
    var zahl =parseFloat(document.forms["formSave"].elements[beitrquartmonatoffen].value.replace(",","."));
   Zwischenspeicher = zahl.toFixed(2);
   
 
}

//onblur offen- Speichert neuen Wert ins Speicher Array
function changevalue(name){
    
    var str = name.toString().split("_");
    var beitrquartmonatoffen="Beitr_"+str[1]+"_QuartMonat_offen";
    var beitrquartmonatgez="Beitr_"+str[1]+"_QuartMonat_gez";


if(document.forms["formSave"].elements[beitrquartmonatoffen].value === ""){
    document.forms["formSave"].elements[beitrquartmonatoffen].value =0;
    document.forms["formSave"].elements[beitrquartmonatgez].value =0;
}
    
    var zahl= parseFloat(document.forms["formSave"].elements[beitrquartmonatoffen].value.replace(",","."));
    if(zahl.toFixed(2) !== Zwischenspeicher){
     var x = parseInt(str[1])-parseInt(1); 
     
     
  Speicher[x] = zahl.toFixed(2);

  
  
  
  Zwischenspeicher=0;
  compute(name);
    }
  
}


//onblur gez

          function compute(name){
              
              var str1 = name.toString().split("_");
              var str = parseInt(str1[1])-parseInt(1);
              var beitrquartmonatoffen="Beitr_"+str1[1]+"_QuartMonat_offen";
              var beitrquartmonatgez="Beitr_"+str1[1]+"_QuartMonat_gez";
              
              

              
var differenz;
document.getElementById("demo5").innerHTML="onblur gez compute  vor bed:"+document.forms["formSave"].elements[beitrquartmonatgez].value;

             if(document.forms["formSave"].elements[beitrquartmonatgez].value === ""){
                  differenz =parseFloat(Speicher[str])-parseFloat(0);
                  
               document.getElementById("demo").innerHTML="onblur gez compute differenz in bed1:"+differenz;

                  document.forms["formSave"].elements[beitrquartmonatgez].value=parseInt(0);
                  
                  differenz=parseFloat(differenz);
                  differenz=differenz.toFixed(2);
                  document.forms["formSave"].elements[beitrquartmonatoffen].value = differenz.replace(".",",");
             }
             
             
             
             else if(Speicher[str] !== "0.00"){
              
               differenz =parseFloat(Speicher[str])-parseFloat(document.forms["formSave"].elements[beitrquartmonatgez].value.replace(",","."));
              differenz = parseFloat(differenz);
              differenz=differenz.toFixed(2);
              document.getElementById("demo2").innerHTML="onblur gez compute differenz in bed2:"+differenz;
              document.forms["formSave"].elements[beitrquartmonatoffen].value = differenz.replace(".",",");
             
        }
        
        
            
             
              
              document.getElementById("demo3").innerHTML="onblur gez compute differenz nach bed:"+differenz;
              
        
              
              if(str1[1] <= 3){
                  
                  
              var summe = parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_gez"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_gez"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_gez"].value.replace(",","."));
              var summe2 = parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."));
              
              var summe=parseFloat(summe);
              var summe2=parseFloat(summe2);
              
               var summe=summe.toFixed(2);
              var summe2=summe2.toFixed(2);
              
             document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value=summe2.replace(".",",");
             document.forms["formSave"].elements["Mtgl_gebQuart1_bezahlt"].value=summe.replace(".",",");
         }
         
        else if(str1[1] >= 4 && str <=6){
              var summe = parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_gez"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_gez"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_gez"].value.replace(",","."));
              var summe2 = parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."));
              
              
              var summe=parseFloat(summe);
              var summe2=parseFloat(summe2);
              
               var summe=summe.toFixed(2);
              var summe2=summe2.toFixed(2);
              
              
              
             document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value=summe2.replace(".",",");
             document.forms["formSave"].elements["Mtgl_gebQuart2_bezahlt"].value=summe.replace(".",",");
         }
            else if(str1[1] >=7 && str1[1] <=9){
              var summe = parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_gez"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_gez"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_gez"].value.replace(",","."));
              var summe2 = parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."));
              
              var summe=parseFloat(summe);
              var summe2=parseFloat(summe2);
              
               var summe=summe.toFixed(2);
              var summe2=summe2.toFixed(2);
              
              
             document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value=summe2.replace(".",",");
             document.forms["formSave"].elements["Mtgl_gebQuart3_bezahlt"].value=summe.replace(".",",");
         }
         
        else if(str1[1] >=10){
              var summe = parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_gez"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_gez"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_gez"].value.replace(",","."));
              var summe2 = parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",",".")) + parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."));
             
            var summe=parseFloat(summe);
              var summe2=parseFloat(summe2);
              
               var summe=summe.toFixed(2);
              var summe2=summe2.toFixed(2);
              
            
            
            document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value=summe2.replace(".",",");
             document.forms["formSave"].elements["Mtgl_gebQuart4_bezahlt"].value=summe.replace(".",",");
         }
        }
    
    
    
    
        function setMtlGebQuart(str){
            

            var res = str.split("/");

 
 if(res[0] === "ja"){
     
     if(res[2]==="Q1"){
        
      document.forms["formSave"].elements["Mtgl_gebQuart1_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_1_QuartMonat_gez"].value =parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value =parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_2_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_3_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q2"){
      document.forms["formSave"].elements["Mtgl_gebQuart2_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_4_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_5_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_6_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q3"){
      document.forms["formSave"].elements["Mtgl_gebQuart3_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_7_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_8_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_9_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q4"){
      document.forms["formSave"].elements["Mtgl_gebQuart4_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_10_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_11_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_12_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 }
 
 else if(res[0] === "nein"){
 if(res[2]==="Q1"){
     
      document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart1_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_1_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_2_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_3_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q2"){
      document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart2_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_4_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_5_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_6_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q3"){
      document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart3_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_7_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_8_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_9_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q4"){
      document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart4_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_10_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_11_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_12_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."));
     
     
 }    
    
 }
 
 else if(res[0] === "geaend"){
 if(res[2]==="Q1"){
     
      document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart1_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart1_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_1_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_1_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_2_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_2_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_3_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_3_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q2"){
      document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart2_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart2_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_4_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_4_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_5_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_5_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_6_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_6_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q3"){
      document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart3_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart3_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_7_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_7_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_8_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_8_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_9_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_9_QuartMonat_offen"].value.replace(",","."));
     
     
 }
 
 if(res[2]==="Q4"){
      document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_bezahlt"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Mtgl_gebQuart4_bezahlt"].value=parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Mtgl_gebQuart4_offen"].value.replace(",","."));
     
     
     document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_10_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_10_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_11_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_11_QuartMonat_offen"].value.replace(",","."));
     
     document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value=parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_gez"].value.replace(",","."))+parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."));
     document.forms["formSave"].elements["Beitr_12_QuartMonat_gez"].value=parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."))-parseFloat(document.forms["formSave"].elements["Beitr_12_QuartMonat_offen"].value.replace(",","."));
     
     
 }    
    
 }
            
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        var $collectionHolder;

// setup an "add a tag" link
var $addRehabLink = $('<a href="#" class="add_rehab_link">Add a tag</a>');
var $newLinkLi = $('<li></li>').append($addRehabLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.tags');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addRehabLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addRehabForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(1, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}