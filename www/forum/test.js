자바스크립트
<script type="text/javascript">
이거 굳이 안 해줘도 됨

스크립트를 아래 위치시키는 것이 페이지 로드 속도를 개선시킬 수 있다.

아웃풋 메소드
window.alert(). //window 생략 가능
document.write(). //테스트용으로만 사용
.innerHTML. //엘리먼트 객체에 사용
console.log(). //개발자도구의 console 창에 로그를 남겨준다.

자스에선 문자열 결한 연산자로 +를 사용한다.
"John" + " "  + "Doe"

값 없이 선언한 변수의 타입은 undefined다.
var carName;

선언을 두번 해도 값은 변하지 않는다.
var carName = "Volvo";
var carName; //여전히 값은 Volvo다.

+ 연산은 문자열을 만난 시점부터 문자열 연산이 된다.
x = 2 + 3 + "5"; //55

자스 타입들
var x;                                      // undefined
var length = 16;                               // Number
var lastName = "Johnson";                      // String
var cars = ["Saab", "Volvo", "BMW"];           // Array
var x = {firstName:"John", lastName:"Doe"};    // Object
var y = false;                                // boolean

자스에선 배열도 내부적으로 사실상 오브젝트다.
그리고 null도 오브젝트다. 
typeof "John"                // Returns "string" 
typeof 3.14                  // Returns "number"
typeof false                 // Returns "boolean"
typeof [1,2,3,4]             // Returns "object" (not "array", see note below)
typeof {name:'John', age:34} // Returns "object"
var person; typeof person;   // undefined
var person = null;           // Value is null, but type is still an object

null과 false의 비교
null === undefined           // false 타입까지 비교하면 거짓
null == undefined            // true 값만 비교하면 참

자바는 연상 배열이 없지만 오브젝트로 똑같은 효과를 볼 수 있다.
var car = {type:"Fiat", model:"500", color:"white"};
car.type // 이런 방식으로 속성에 접근할 수 있다.
car['type'] // 이 방식도 지원한다.

오브젝트는 메소드를 가질 수 있다.
var person = {
    firstName: "John",
    lastName : "Doe",
    id       : 5566,
    fullName : function() {
       return this.firstName + " " + this.lastName;
    }
};
person.fullName() //메소드 접근은 이런식으로 한다.(자바와 비슷)

자스의 변수 유효 범위
자스는 일반적인 언어들의 변수 스코프를 따른다.(php랑 다름)
특이하게 오토 글로벌이 있다는 점과 모든 글로벌 변수가 window 오브젝트에 속해 있다는 것을 알아 두자.
지역변수:
function myFunction() {
    var carName = "Volvo"; //지역변수
}
// 여기서 carName 사용 불가능
전역변수:
var carName = " Volvo"; //전역 변수
function myFunction() {
    // carName 사용 가능
}
오토 글로벌
myFunction();
// 이 위치에서 함수 내의 carName을 쓸 수 있다.
function myFunction() {
    carName = "Volvo"; // carName은 선언 없이 사용함으로 전역변수를 쓰는 것을 암시한다.
}                      // 따라서 자동적으로 전역 변수가 생성된다.
모든 전역 변수는 window 오브젝트의 속성이다.
var carName = "Volvo";
window.carName // 따라서 이런식으로 접근이 가능하다.
*** window 오브젝트에 기본적으로 내장된 모든 속성, 메소드는 사용자가 오버라이딩 할 수 있다.

스트링
모든 문자열 변수는 length 속성을 갖는다.
var txt = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
var sln = txt.length;
"안녕".length; //이런 것도 가능

이스케이프
\'	single quote
\"	double quote
\\	backslash
""(큰따옴표), ''(작은 따옴표) 상관없이 똑같이 적용된다.

자스의 기본 타입들은 모두 오브젝트로 선언될 수 있다.
var x = "John";             
var y = new String("John");
// (x == y) is true 값만 비교하면 참
// (x === y) is false 타입까지 비교할 경우 거짓

var x = new String("John");             
var y = new String("John");
// (x == y) is false
이런식으로 각각 오브젝트로 선언한 경우 값이 같아도 false다.

스트링 속성과, 메소드들
1. length 속성
var txt = "안녕"; 
var sln = txt.length; //2 유니코드이기 때문에 한글도 한글자당 1이다.
2. indexOf() 메소드
var str = "Please locate where 'locate' occurs!";
var pos = str.indexOf("locate"); // 7
//다음 문자열이 첫번째로 시작된 인덱스 값을 가져온다.
2. lastIndexOf() 메소드
var str = "Please locate where 'locate' occurs!";
var pos = str.lastIndexOf("locate"); // 21
//다음 문자열이 마지막으로 시작된 인덱스 값을 가져온다.
3. search() 메소드
var str = "Please locate where 'locate' occurs!";
var pos = str.search("locate"); // 7
// indexOf()와 같아 보이지만 정규식을 사용할 수 있다.
4. substring() 메소드
var str = "Apple, Banana, Kiwi";
var res = str.substring(7,13); // banana 7~12 인덱스의 문자열을 반환
var str = "Apple, Banana, Kiwi";
var res = str.substr(7,6); // banana 7부터 5개의 문자열을 반환
5. replace() 메소드
str = "Please visit Microsoft!";
var n = str.replace("Microsoft","W3Schools");
//문자열 치환 메소드다. 단, 첫번째 찾은 문자열만 치환한다.
str = "Please visit Microsoft!";
var n = str.replace(/Microsoft/g,"W3Schools");
// 이 방식으로 하면 모든 문자열을 치환할 수 있다.(정규식)
6.  toUpperCase(), toLowerCase() 메소드
var text1 = "Hello World!";       // String
var text2 = text1.toLowerCase();  // text2 is text1 converted to lower
//대문자 소문자로 만들어 준다.
7. 문자열 뽑아 내기
두가지 방법이 있다.
var str = "HELLO WORLD";
str.charAt(0);            // returns H
var str = "HELLO WORLD";
str[0];                   // returns H php처럼 배열로 접근할 수 있다.
8. split() 메소드
var str = "a,b,c,d,e,f";
var arr = str.split(","); //배열을 반환한다.
arr[2] // c

배열
var cars = ["Saab", "Volvo", "BMW"];
var cars = new Array("Saab", "Volvo", "BMW");
// 위 두 방식으로 배열을 만들 수 있다.
var cars = ["Saab", "Volvo", "BMW"];
alert(cars); // Saab,Volvo,BMW 이렇게 나온다.

배열 루프는 그냥 전통적인 방식으로 하면 된다.
var fruits, text, fLen, i;
fruits = ["Banana", "Orange", "Apple", "Mango"];
fLen = fruits.length;
text = "<ul>";
for (i = 0; i < fLen; i++) {
    text += "<li>" + fruits[i] + "</li>";
}
** 자스는 연상 배열을 지원 안한다.
따라서 배열은 숫자로, 오브젝트는 키이름으로 접근한다.

배열인지 확인하는 방법
Array.isArray(fruits);     // returns true

자스 예외 처리
try {
    adddlert("Welcome guest!"); // 알아서 예외 날려준다.(존재하지 않는 함수)
}
catch(err) {
    document.getElementById("demo").innerHTML = err.message; // message 속성에 오류 메세지가 들어있다.
}

자스는 throw로 문자열을 날려줄 수 있다.
function myFunction() {
    var message, x;
    message = document.getElementById("message");
    message.innerHTML = "";
    x = document.getElementById("demo").value;
    try { 
        if(x == "") throw "is empty";
        if(isNaN(x)) throw "is not a number";
        x = Number(x);
        if(x > 10) throw "is too high";
        if(x < 5) throw "is too low";
    }
    catch(err) {
        message.innerHTML = "Error: " + err + "."; //err은 문자열이다.
    }
    finally {
        document.getElementById("demo").value = "";
    }
}

코드 상단에 "use strict"; 을 선언함으로 엄격한 코딩을 할 수 있다.
예를 들면 선언 되지 않는 변수를 사용할 수 없다.

폼 관련 유용한 코드
<!DOCTYPE html>
<html>
<head>
<script>
function validateForm() {
    var x = document.forms["myForm"]["fname"].value;
    if (x == null || x == "") {
        alert("Name must be filled out");
        return false;
    }
}
</script>
</head>
<body>
<form name="myForm" action="demo_form.asp" onsubmit="return validateForm()" method="post">
Name: <input type="text" name="fname">
<input type="submit" value="Submit">
</form>
</body>
</html>
// 보면 onsubmit에 validateForm() 다음 함수 명시했다.
즉, submit 되 기전에 저 함수를 먼저 실행한다. 
유효성 검사에 부적합하면 false를 리턴한다. 
false를 리턴하면 action페이지로 넘어가지 않는다.
여기서 주의 할게 있다.!!!
onsubmit="return validateForm()"
이렇게 리턴 값으로 함수를 준 것을 잘 기억하자.
이렇게 해야 페이지가 넘어가는 것을 막을 수 있다.
onsubmit="validateForm()" 이렇게는 막을 수 없다.

object를 생성하는 2가지 방법
1.
var person = {
    firstName:"John",
    lastName:"Doe",
    age:50,
    eyeColor:"blue"
};
2.
var person = new Object();
person.firstName = "John";
person.lastName = "Doe";
person.age = 50;
person.eyeColor = "blue";
// 두번째 방법은 좀 독특하긴하다. (마치 연상 배열을 사용하는 것 같은 방식이다.)

위 방법들은 단순히 1개의 오브젝트를 만드는 방법이다.
자스는 클래스를 지원하지는 않지만 비슷하게 구현하는 방법을 제공한다.
function person(first, last, age, eye) { // 이런식으로 생성자 함수를 만든다.
    this.firstName = first;
    this.lastName = last;
    this.age = age;
    this.eyeColor = eye;
}
var myFather = new person("John", "Doe", 50, "blue"); // 함수를 new연산자를 통해 오브젝트를 생성한다.
var myMother = new person("Sally", "Rally", 48, "green");
// 즉, 자스에서는 생성자 함수의 정의가 곧 클래스의 정의라고 보면된다. (물론 클래스는 아니지만)

자스도 객체 대입 연산은 복제가 아닌 참조가 된다.
var person = {firstName:"John", lastName:"Doe", age:50, eyeColor:"blue"}
var x = person;
x.age = 10;
alert(person.age); // 10

for in 루프
php의 foreach와 거의 비슷하다.
배열 뿐만 아니라 객체의 속성도 순회할 수 있다.
1. 배열에 적용
var txt = "";
var person = [1,2,3,4,5];
var x;
for (x in person) {
    txt += person[x] + " ";
}
//text = 1 2 3 4 5
2. 오브젝트에 적용
var txt = "";
var person = {fname:"John", lname:"Doe", age:25, aa:function(){}};
var x;
for (x in person) {
    txt += person[x] + " ";
}
//text = John Doe 25 function (){} //메서드까지도 순회하는 것을 알 수 있다.
**둘다 []로만 접근 가능하다. '.(점)'으로 접근할 수 없다.

프로퍼티 삭제(자스에서 프로퍼티에는 메서드도 포함된다는 것을 잊지 말자.)
var person = {firstName:"John", lastName:"Doe", age:50, eyeColor:"blue"};
delete person.age;   // or delete person["age"];
// delete 키워드를 사용한다. 키, 값 모두 지운다.

제대로된 오브젝트 프로토타입(클래스)을 만들어 보자.
function person(firstName,lastName,age,eyeColor) {
    this.firstName = firstName;
    this.lastName = lastName;
    this.age = age;
    this.eyeColor = eyeColor;
    this.changeName = function (name) {
        this.lastName = name;
    }
}
var myMother = new person("Sally","Rally",48,"green");

이미 만들어진 프로토타입으로 생성된 오브젝트는 각각 프로퍼티나 메소드를 추가할 수 있다.
function Person(first, last, age, eye) {
    this.firstName = first;
    this.lastName = last;
    this.age = age;
    this.eyeColor = eye;
}
var myFather = new Person("John", "Doe", 50, "blue");
myFather.nationality = "English"; // 오브젝트에 프로퍼티 추가
myFather.name = function () {
    return this.firstName + " " + this.lastName;
};// 메소드 추가

단, 프로토타입 자체에 새로운 메소드나 프로퍼티를 추가하기 위해선 다른 문법을 쓴다.
function Person(first, last, age, eye) {
    this.firstName = first;
    this.lastName = last;
    this.age = age;
    this.eyeColor = eye;
}
Person.prototype.nationality = "English";
Person.prototype.AA = function(){return this.age};
// 이런식으로 접근한다.

자스는 자기 호출 함수를 지원한다.
위에서 봤다싶이 익명함수를 지원한다는 것을 알고 있다.
(function () {document.write('hi')})()
익명함수에 이런식으로 하여 자기 호출 함수를 만들 수 있다.

파라미터의 수도 알 수 있다.
function myFunction(a, b) {
    return arguments.length; //this.arguments가 아니다.
}
// 함수 내에서 arguments.length를 사용한다.

자스에서 정해진 파라미터에 아무것도 넣지 않을 경우 undefined가 된다.
function myFunction(x, y) {
    if (y === undefined) {
        y = 0;
    }
    return x * y;
}

함수 내장 오브젝트 arguments!!
이것을 이용하여 인자수가 가변적인 함수를 만들 수 있다.

자스의 함수는 기본적으로 call by value다.
단, 오브젝트 자체를 파라미터로 넘기면 call by reference가 된다.(php도 마찬가지다.)
function A(x) {
 x.b = 3;
}
var a = {b:1};
A(a);
a.b // 3

배열 또한 배열 자체를 파라미터로 넘기면 참조 전달이 된다.
var arr = [1,2,3];
function foo(x)
{
  for(k in x)
  {
     x[k] = 0;
  }
}
foo(arr);
alert(arr); //0, 0, 0

주의! 오브젝트의 하나의 속성 또는 배열 원소 하나를 파라미터로 보낼때는 값전달인 것을 잊지 말자!
var arr = {a:1};
function AA(a)
{
 a = 0;
}
AA(arr.a); // 실제 값은 변하지 않는다.

전역으로 정의된 모든 함수는 window오브젝트의 메소드가 된다.
function myFunction(a, b) {
    return a * b;
}
window.myFunction(10, 2); // 따라서 이런식으로도 호출이 가능하다.

전역으로 정의된 모든 함수의 this는 window오브젝트가 된다.
function myFunction() {
    return this;
}
myFunction();  //[object Window]

오브젝트의 메소드의 this 자기 자신의 오브젝트가 된다.
var myObject = {
    firstName:"John",
    lastName: "Doe",
    fullName: function () {
        return this;
    }
}
myObject.fullName();  // Will return [object Object] (the owner object)

자스에서의 '클로저'는 익명함수를 뜩하는 게 아니다. 매우 재밌고 심오한 방식을 클로저라 한다.
var add = (function () {
    var counter = 0;
    return function () {return counter += 1;}
})();
add();
add();
add(); //3이 호출된다.
설명:
자스에서는 함수 내에 함수를 정의할 수 있고 그 정의돈 함수를 호출할 수도 있다.
일단 외부 함수는 var counter = 0; 을 한번 실행한 뒤 역할을 다한다.
대신 함수 return counter += 1;를 해주는 함수를 변수 add에게 리턴해준다.
그러면 add는 내부함수를 사용할 수 있게 된다.
따라서 add()로 계속 값을 증가시킬 수 있지만 counter 변수 자체에 직접적으로 접근할 방법은 사라진다.

DOM이란?
Document Object Model로서 html문서 내의 모든 엘리먼트의 오브젝트로 계층(트리구조)화 한 것이다.
브라우저가 로드될 때 현재 페이지의 DOM의 구조도 결정된다.
DOM은 문서에 접근하는 표준을 정의한다.
DOM으로 할 수 있는 것들:
페이지 내 모든 엘리먼트를 변형할 수 있다.
페이지 내 모든 어트리뷰트를 변형할 수 있다.
페이지 내 모든 CSS를 변형할 수 있다.
존재하는 엘리먼트와 어트리뷰트를 제거할 수 있다.
새로운 엘리먼트와 어트리뷰트를 추가할 수 있다.
페이지 내에 존재하는 모든 이벤트에 대한 리엑션을 할 수 있다.
페이지 내에 새로운 이벤트를 만들 수 있다.

document는 dom에서 최상위 오브젝트다.(루트, 근노드)

엘리머트에 접근하는 document메소드들
document.getElementById(id)
document.getElementsByTagName(name)
document.getElementsByClassName(name)

각 엘리먼트 오브젝트들이 가지고 있는 프로퍼티와 메소드들
element.innerHTML =  new html content	
element.attribute = new value
element.setAttribute(attribute, value)
element.style.property = new style

document 오브젝트는 새로운 엘리먼트를 추가하거나 삭제하는 메소드들을 가지고 있다.
document.createElement(element)	Create an HTML element
document.removeChild(element)	Remove an HTML element
document.appendChild(element)	Add an HTML element
document.replaceChild(element)	Replace an HTML element
document.write(text)	Write into the HTML output stream

각 엘리먼트 오브젝트는 이벤트 핸들러를 가질 수 있다.
document.getElementById(id).onclick = function(){code}

DOM도 레벨이 있다. 만들어진 시기가 최근일수록 레벨이 높다.

미리 정의된 엘리먼트 오브젝트들은 다음과 같이 접근할 수 있다.
document.anchors
document.body
document.documentElement
document.embeds
document.forms
document.head
document.images
document.links
document.scripts
document.title
// 독립적인 오브젝트를 반환하는 것도 있고 여러개 존재하는 엘리먼트는 배열을 반환한다.

엘리먼트 찾는 방법
var myElement = document.getElementById("intro"); // id가 intro인 엘리먼트 하나를 오브젝트로 반환한다.
var x = document.getElementsByTagName("p"); // 모든 p태그 엘리먼트들을 오브젝트 배열로 반환한다.
var x = document.getElementsByClassName("intro"); // class로 찾는 건데 ie8이하 버전에서 안된다.
var x = document.querySelectorAll("p.intro"); // css 셀렉터로 찾는 건데 ie8이하 버전에서 안된다.


엘리먼트 내의 오브젝트에서 또다른 엘리먼트 오브젝트를 찾을 수도 있다.
<div id="main">
<p>The DOM is very useful.</p>
<p>This example demonstrates the <b>getElementsByTagName</b> method</p>
</div>
<script>
var x = document.getElementById("main");
var y = x.getElementsByTagName("p"); // main 내의 p 엘리먼트를 찾는다.
</script>

스타일을 변경할 때 주로 쓰는 방식
document.getElementById("p2").style.color = "blue";

어트리뷰트를 변경할 때 주로 쓰는 방식
document.getElementById("myImage").src = "landscape.jpg";

함수를 반복적으로 실행하게 할 수 있는 함수가 있다.
var id = setInterval(frame, 1000); //1초 간격으로 반복한다.(1000분의 1초 단위임)
function frame(){}
if (pos == 350) { clearInterval(id);} // clearInterval(id)으로 특정 시점에 반복을 멈출 수 있다.
// 꼭 위처럼 setInterval()을 전역 변수로 받야 멈출 수 있다.

이벤트 처리할 때 this
<h1 onclick="changeText(this)">Click on this text!</h1> //이런식으로 this를 넣으면 해당 엘리먼트 오브젝트가 전달된다.
<script>
function changeText(id) {
    id.innerHTML = "Ooops!"; // getElementById()를 따로 해줄 필요 없다. this자체가 오브젝트이기 때문이다.
}
</script>

자스는 기본적으로 php처럼 동적 영역 할당이 아니다.
정적 영역 할당이다.
var a = 3;
function AA()
{
  alert(a);
}
function BB()
{
	var a = 4;
	AA();
}
BB(); // 3을 출력하는 것을 보면 알 수 있다.

태그의 속성으로 함수가 들어가도 마찬가지다.
<p onclick="myfnc()">Hello World!</p> // 클릭할 경우 window 오브젝트를 출력한다.
<script>
function myfnc()
{
 alert(this);
}
</script>

단, 예외적인 경우들이 좀 있다.
<p>Hello World!</p>
<script>
var p = document.getElementsByTagName('p')[0];
p.addEventListener('click', myfnc); // pargraph 엘리먼트 오브젝트를 출력한다.
function myfnc()
{
 alert(this);
}
myfnc(); //window 오브젝트 출력
</script>
// 위 예제로 알 수 있듯 함수가 정의 된 기준이 아닌 호출된 기준에서 변수에 접근한다.
// 일단은 좀 애매하니 돔 오브젝트의 메소드에서 쓰였을 때만 이런식으로 동적 영역 할당이 된다고 알아 두자.

이벤트 핸들링하는 두가지 방법
어트리뷰트를 이용한 방법:
<button onclick="displayDate()">Try it</button>
DOM을 이용한 방법:
document.getElementById("myBtn").onclick = displayDate; //함수 이름을 쓰거나 익명함수를 쓰면된다.

onload 이벤트
<iframe onload="myFunction()" src="/default.asp"></iframe>
이 이벤트를 이용하여 이미지 등의 로딩 표시를 할 수 있을 것 같다.

onchange 이벤트
셀렉트 엘리먼트에선 선택 옵션이 바뀔 때나 인풋 텍스트가 포커스를 잃을 때 발생한다.

mouseover, mouseout
이 두가지로 호버를 구현할 수 있다.

onmousedown, onmouseup
마우스를 누르고 있는 동안과 떼었을 때를 이벤트로 잡을 수 있다.

onmousemove
마우스가 움직이는 동안의 이벤트
내가 자리배치도 만들 때 이 이벤트와 event.clientX, event.clientY, style.left, style.top 등으로 좌표를 구해 만들었었다.

setTimeout()
setTimeout(function(){ alert("Hello"); }, 3000);
//3초 뒤에 해당 함수가 실행된다.
var myVar = setTimeout(function(){ alert("Hello"); }, 3000);
clearTimeout(myVar); //3초 전에 이함수가 실행되면 myVar는 실행되지 않는다.

이벤트리스너 방식을 알아보자.
addEventListener(이벤트명, 함수명 or 익명함수)
element.addEventListener("click", myFunction); // 이벤트를 'on'을 붙이지 않고 쓴다는 것을 기억하자.

이벤트리스너를 쓰면 좋은 점
1. 한 엘리먼트에 같은 이벤트에 여러 함수를 지정할 수 있다.
var x = document.getElementById("myBtn");
x.addEventListener("click", myFunction);
x.addEventListener("click", someOtherFunction);
// 이런식으로 하면 마지막 것으로 덮어 씌운다.
var x = document.getElementById("myBtn");
x.onclick = function(){alert('hi')};
x.onclick = function(){alert('hello')}; // 이것만 실행됨

2. window 오브젝트에도 이벤트를 걸 수 있다.
window.addEventListener("resize", function(){});
window.onresize = function(){} //근데 이렇게도 되긴된다.

3. 버블링과 캡쳐링을 할 수 있다.
addEventListener(이벤트, 함수, 전파 방식)
세 번째 파라미터로 캡처링과 버블링을 구사할 수 있다.
디폴트 값 = true로 캡처링이다.
false를 주면 버블링이 된다.
예)
<div id="myDiv">
  <div id="myP" style="padding:50px; background:yellow">
    <h1 id="myH1" style="background:green">Click this paragraph, I am Capturing.</h1>
  </div>
</div>
myDiv, myP, myH1 모두 클릭 이벤트리스너를 가지고 있다고 해보자.
위와 같은 상황에서 myH1을 클릭하면 myP, myDiv도 클릭한 것이 된다.
기본적으로 이벤트를 만나는 순서는 가장 바깥쪽 엘리먼트가 된다. 즉, myH1를 클릭해도 myDiv를 먼저 만나게 된다.
만약 myDiv의 이벤트리스너에 false를 준다면 myDiv 내부에 먼저 발생될 이벤트가 있는지 찾게된다.
그러면 myP에 접근하게 되고 myP도 false를 주면 또 그 안에서 먼저 발생될 이벤트가 있는지 찾게 된다.
그러면 결국 myH1이 가장 먼저 발생되고 다음으로 myP, myDiv 순으로 발생된다.
따라서 제일 안쪽 엘리먼트가 true인지 false인지 중요하지 않다. 보다시피 바깥 엘리먼트의 값에 따라 결정 되기 때문이다.
myDiv: true, myP: false, myH1 = myDiv-> myH1-> myP 순서로 진행
myDiv: false, myP: true, myH1 = myP-> myH1-> myDiv 순서로 진행

4. 이벤트리스너를 지울 수 있다.
document.getElementById("myDIV").addEventListener("mousemove", myFunction);
document.getElementById("myDIV").removeEventListener("mousemove", myFunction)

5. 함수에 파라미터를 넘길 때 익명함수 안에서 호출하면된다.(아니면 바로 익명함수를 정의하든지 그렇지 않으면 함수 이름만 써야되니까)
document.getElementById("myBtn").addEventListener("click", function() {
    myFunction(p1, p2);
});

구버전 브라우저에서는 addEventListener를 지원하지 않을 수 있다.
대신 구버전에선 다음 두 방식을 지원한다.
element.attachEvent(event, function);
element.detachEvent(event, function);
호환성을 위해서 다음과 같은 코드를 쓸 수 있다.
var x = document.getElementById("myBtn");
if (x.addEventListener) {                    // For all major browsers, except IE 8 and earlier
    x.addEventListener("click", myFunction);
} else if (x.attachEvent) {                  // For IE 8 and earlier versions
    x.attachEvent("onclick", myFunction);
}

DOM은 처음에 말했다시피 트리구조다.
1. 모든 엘리먼트는 하나의 노드다.
2. 엘리먼트 안의 텍스트도 하나의 노드다.
3. 엘리먼트의 모든 어트리뷰트도 하나의 노드다.
4. 심지어 주석도 하나의 노드다.
5. 모든 노드는 자스로 접근할 수 있다.(즉, 수정, 삭제, 추가가 가능하다.)

DOM을 살펴 보자.
<html>
  <head>
      <title>DOM Tutorial</title>
  </head>
  <body>
      <h1>DOM Lesson one</h1>
      <p>Hello world!</p>
  </body>
</html>

<html> is the root node
<html> has no parents
<html> is the parent of <head> and <body>
<head> is the first child of <html>
<body> is the last child of <html>
<head> has one child: <title>
<title> has one child (a text node): "DOM Tutorial" // 텍스트도 노드로서 자식인 것을 기억하자.
//보통 텍스트 노드에는 innerHTML로 접근한다.
<body> has two children: <h1> and <p>
<h1> has one child: "DOM Lesson one"
<p> has one child: "Hello world!"
<h1> and <p> are siblings

DOM에서 다른 엘리먼트를 찾기 위해 사용할 수 있는 프로퍼티들이다.
parentNode
childNodes[nodenumber] // 배열로 반환
firstChild
lastChild
nextSibling
previousSibling

착각하기 쉬운 부분(innerHTML과 nodeValue)
<button onclick="myFunction()">Try it<span>AA</span>asdf</button>
<script>
    var c = document.getElementsByTagName("BUTTON")[0];
    var x = c.childNodes[2].nodeValue; // asdf 텍스트 노드이니 nodeValue를 쓴다.
    var x = c.childNodes[1].innerHTML; // AA 엘리먼트 노드이니 innerHTML을 쓴다.
</script>
//<button>은 총 3개의 자식을 가지고 있다.-> 텍스트노드:Try it, 엘리먼트 노드:<span>, 텍스트노드:asdf
1. innerHTML은 엘리먼트 오브젝트에 사용하는 것이다.
2. nodeValue는 텍스트 노드에 사용하는 것이다.
**참고 한칸의 공백이라도 텍스트 노드가 된다.
예)
<span></span><div></div> // span과 div 사이에 텍스트 노드가 없다.
<span></span> <div></div> // span과 div 사이에 텍스트 노드가 있다.
// 또한 span과 div 엘리먼트도 텍스트노드를 가지고 있지 않다.(공백조차 없으니)

이 예제를 보고 한번 더 확인하자.
<h1 id="intro">My First Page</h1>
<p id="demo">Hello World!</p>
<script>
var myText = document.getElementById("intro").childNodes[0].nodeValue;
document.getElementById("demo").innerHTML = myText;
</script>
//각각 nodeValue와 innerHTML로 접근했다.

firstChild는 childNodes[0]과 같다.
myText = document.getElementById("intro").firstChild.nodeValue;

document.body와 document.documentElement
alert(document.body.innerHTML);// body 내의 내용만 출력
alert(document.documentElement.innerHTML); // <html></html> 내의 전체 내용 출력

nodeName 프로퍼티
nodeName 은 읽을 수만 있다.(변형 불가)
엘리먼트 노드는 nodeName은 태그 이름이다.
어트리뷰트 노드의 nodeName은 어트리뷰트 이름이다.
텍스트 노드의 nodeName은 #text이다.
document노드의 nodeName은 #document이다.
** 어트리뷰트 노드에 접근하는 방법은 이렇다.
엘리먼트.attributes[0].nodeName;
원하는 어트리뷰트를 찾을 땐 이런식으로
엘리먼트.getAttributeNode("class") // 해당 어트리뷰트의 값을 리턴한다.
**참고 어트리뷰트 컨트롤하는 가장 간단한 방법: document.getElementsByTagName("H1")[0].setAttribute("class", "democlass");

nodValue 프로퍼티
엘리먼트 노드는 undefined
텍스트 노드는 텍스트 내용
어트리뷰트 노드는 그 어트리뷰트의 값
** 어트리뷰트 노드에 접근하는 방법은 이렇다.
엘리먼트.attributes[0].nodeValue;

노드를 추가하거나 지우는 방법
DOM에서 노드를 추가하거나 삭제하기 위해선 항상 보모노드의 객체가 필요하다.

1. 엘리먼트 노드를 추가하는 방법
<div id="div1">
<p id="p1">This is a paragraph.</p>
<p id="p2">This is another paragraph.</p>
</div>
<script>
var para = document.createElement("p");
var node = document.createTextNode("This is new.");
para.appendChild(node); // 추가할 노드 완성
var element = document.getElementById("div1"); // 부모 노드 오브젝트 생성
element.appendChild(para); // 마지막 자식으로 추가
</script>
설명: 엘리먼트노드를 만든다-> 만들어진 노드에 텍스트노드도 추가한다-> 그리고 그것을 부모 노드에 추가한다.
document.createElement()
document.createTextNode()
부모노드.appendChild()
// 위 세 메소드가 속한 오브젝트를 잊지말자.
// create는 무조건 document의 오브젝트다.

2. 부모노드.appendChild()를 하면 마지막 자식이 된다. 중간에 넣기위해 
부모노드.insertBefore(추가노드, 이놈 앞에)
이 방식을 쓰기 위해선 어떤 놈 앞에 들어가야 하는데 그 놈의 오브젝트도 생성해야 한다.
예)
<div id="div1">
<p id="p1">This is a paragraph.</p>
<p id="p2">This is another paragraph.</p>
</div>
<script>
var para = document.createElement("p");
var node = document.createTextNode("This is new.");
para.appendChild(node); // 추가할 노드 완성
var element = document.getElementById("div1"); //부모 노드의 오브젝트 생성
var child = document.getElementById("p1"); // 세치기 당할 놈의 오브젝트도 생성
element.insertBefore(para,child); // 그놈 앞으로 추가된다.
</script>

3. 존재하는 노드도 삭제할 수 있다.
노드를 삭제하기 위해서도 부모 노드를 알아야 한다.
부모노드.removeChild(지울놈) 방식을 쓰기 때문이다.
<div id="div1">
<p id="p1">This is a paragraph.</p>
<p id="p2">This is another paragraph.</p>
</div>
<script>
var parent = document.getElementById("div1"); // 부모 노드 오브젝트 생성
var child = document.getElementById("p1"); // 삭제할 놈 오브젝트 생성
parent.removeChild(child); //
</script>
node.remove()라는 메소드가 있지만 브라우저에서 지원을 안하다.
따라서 무조건 부모를 알아야 한다. 대신 간단하게 줄일 수 있는 방법이 있다.
var child = document.getElementById("p1");
child.parentNode.removeChild(child);
//parentNode 프로퍼티를 사용해서 코드를 많이 줄일 수 있다.

4. 노드를 교체할 수도 있다.
부모노드.replaceChild(새로들어갈 놈, 빠질 놈);

5. 어트리뷰트 추가하는 방법
<h1>Hello World</h1>
<p>Click the button to create a "class" attribute with the value "democlass" and insert it to the H1 element above.</p>
<button onclick="myFunction()">Try it</button>
<script>
function myFunction() {
    var h1 = document.getElementsByTagName("H1")[0]; //추가할 엘리먼트를 오브젝트화 한다.
    var att = document.createAttribute("class"); //document.createAttribute()로 원하는 어트리뷰트 오브젝트를 만든다.
    att.nodeValue = "democlass"; //어트리뷰트 오브젝트에 nodeValue로 값을 준다.
    h1.setAttributeNode(att); //setAttributeNode()로 엘리먼트 오브젝트에 붙여준다.
}
</script>

노드리스트
document.getElementsByTagName(name)
document.getElementsByClassName(name)
위와 같은 메소드는 1개의 노드 오브젝트가 아닌 노드리스트 즉, 오브젝트 배열을 반환한다.
**이름에서 주의할 것이 Elements 복수형 's'가 붙는다는 것이다. (Element 가 아니다.)
**노드리스트를 리턴하는 메소드는 모두 복수형 's'가 붙는다.

BOM(Browser Object Model)
DOM이 html 문서의 요소들을 오브젝트로 계층화 했다면.
BOM은 html 문서 외적으로 브라우저가 가지고 있는 정보들을 오브젝트화 하여 계층화 한 것이다.
BOM은 공식적인 표준은 없다. 따라서 브라우저마다 약간씩 다를 수 있다.

BOM의 최상위 노드인 window
모든 글로벌 변수, 함수, 오브젝트는 window오브젝트에 속하게 된다.
글로벌 변수는 window오브젝트의 프로퍼티고
글로벌 함수는 window오브젝트의 메소드이다.
document오브젝트 조차 window오브젝트의 프로퍼티다.
window오브젝트는 브라우저가 띄운 해당 윈도창 자체를 대변한다.
<iframe> 하나도 하나의 window다.

window 오브젝트로 윈도창의 높이와 너비를 알 수 있다.(단, 스크롤, 툴바 등의 크기는 여기에 들어가지 않늗나.)
window.innerWidth
window.innerHeight
단, 브라우저 별로 저 프로퍼티를 지원하지 않을 수도 있다.
따라서 다음과 같이 사용한다.
var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
var h = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

다음과 같은 window 오브젝트 메소드들이 있다.
window.open() - open a new window
window.close() - close the current window
window.moveTo() -move the current window
window.resizeTo() -resize the current window

window.screen
사용자의 화면 즉, 모니터를 대변하는 window.screen
screen.width // 사용자 모니터의 너비를 나타낸다.(해상도 기준)
screen.height // 사용자 모니터의 높이를 나타낸다.(해상도 기준)
screen.availWidth // 작업 표시줄 같은 공간을 뺀 너비를 나타낸다.(해상도 기준)
screen.availHeight // 작업 표시줄 같은 공간을 뺀 높이를 나타낸다.(해상도 기준)
screen.colorDepth // 모니터가 몇비트 칼라인지 알려준다. 내 것은 24bit(설정 기준)
screen.pixelDepth // 픽셀 정보를 준다. 내 것은 24bit(설정 기준)
이 정보들로 반응형 웹을 만드는데 도움을 얻을 수 있겠다.

window.location
URL에 대한 정보를 가지고 있는 오브젝트이다.
window.location.href // 현재 페이지에 대한 url을 나타낸다.
window.location.hostname // 현재 페이지의 호스트 url을 나타낸다.(truekevin.cafe24.com) php의 'HTTP_HOST'와 같다.
window.location.pathname // 호스트 url을 제외한 뒷 주소를 나타낸다.(get 파라미터는 표시되지 않는다.)
window.location.protocol // 현재 페이지의 웹 프로토콜을 나타낸다. (http:, https:, ftp: 등)
window.location.assign(url) // 해당 페이지로 이동한다.
window.location = url // 이렇게 해도 해당 페이지로 이동한다.
window.location.replace(url) // 이렇게 이동할 경우 뒤로가기로 다시 돌아 울 수 없다.
window.location.reload() // 현재 페이지 새로고침

window.history
브라우저의 히스토리에 관한 정보를 가지고 있는 오브젝트이다.
window.history.back() // 뒤로가기 버튼을 클릭한 것과 같은 효과이다.
window.history.forward() // 앞으로가기 버튼을 클릭한 것과 같은 효과이다.

window.navigator
사용자 브라우저에 대한 정보를 가지고 있다.
window.navigator.cookieEnabled // 쿠키 사용이 가능한 브라우저면 true 아니면 false를 반환한다.
window.navigator.appName // 브라우저 이름을 반환한다.
window.navigator.appCodeName // 브라우저 코드 네임을 반환하다.
//IE11, Chrome, Firefox, and Safari return appName "Netscape".
//Chrome, Firefox, IE, Safari, and Opera all return appCodeName "Mozilla".
window.navigator.product //엔진 이름
window.navigator.appVersion // 버전 이름
window.navigator.userAgent // 버전이름(위와 동일)
window.navigator.platform // 플랫폼 정보
window.navigator.language // 언어 정보

팝업 메소드들
window.alert()
window.confirm() // 사용자가 '예, 아니요'를 선택하는 것에 따라 true, false를 반환한다.
window.prompt(메세지,[디폴트 값]) // 사용자가 입력할 수 있는 창을 띄운다.
alert("Hello\nHow are you?"); // \n으로 줄넘김을 할 수 있다.


자바스크립트로 쿠키를 컨트롤 할 수 있다.
document.cookie // 이 프로퍼티 하나만으로 쿠키를 컨트롤해야한다.
document.cookie 는 기본적으로 해당 페이지에 해당되는 모든 쿠키를 리턴한다.
다음과 같은 규칙으로 리턴한다. 'cookie1=value; cookie2=value; cookie3=value;'
'='사이에 띄어쓰기가 없으며 ';'과 다음 쿠키 네임이 사이에만 한칸씩 띄운다.
document.cookie 로 한번에 하나식 쿠키를 생성할 수 있다.
document.cookie = "username=John Smith; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
이런 방식으로 생성한다.
expires와 path는 옵션이다.
expires의 디폴트는 세션이다. 즉, 브라우져가 닫히면 사라진다.
계속 유지하기 위해선 UTC타임 방식으로 만기일 부여하면 된다.
path의 디폴트는 현재 페이지다. 보통은 '/(루트)'로 설정한다.
똑같은 이름의 쿠키를 한번 더 생성하면 전에 있던 것을 덮어 쓰게 된다.
덮어쓴 것에 expires와 path를 쓰지 않으면 역시 이것들도 디폴트 값으로 덮인다.
존재하는 쿠키를 지우기 위해선 만기일을 과거로 하여 덮어쓰면 된다.
var d = new Date(0);
document.cookie = "username=; path=/; expires=".d;//쿠키값은 안 넣어줘도 상관없다.
이런식으로 Date() 오브젝트를 이용하면 편하다. d는 1970년 1월 1일을 UTC로 반환한다.
단, path=/;를 안써줄 경우 현재 페이지 것을 삭제하기 때문에 명확히 해야한다.
만기일도 Date() 오브젝트를 이용하여 만들어보자.
var d = new Date();
var e = 5; // 유지기간
var ex_day = d.setTime(d.getTime()+(e*24*60*60*1000)).toUTCString();
하루를 밀리세컨드로 나타낸 값에 유지기간을 곱한다.
document.cookie = "username=John Smith; path=/; expires"+ex_day;
setTime()의 인자가 밀리세컨드고 getTime()의 리턴값도 밀리센컨드인 것을 잊지 말자.

AJAX
아작스의 핵심은 window.XMLHttpRequest 오브젝트 '타입'이다.
new 키워드로 인스턴스를 생성해서 사용한다.
구버전에서 동작을 위해 다음과 같은 방법을 쓰기도 한다.
var xhttp;
if (window.XMLHttpRequest) {
    xhttp = new XMLHttpRequest();
    } else {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
아작스는 보안상의 이유로 같은 서버와의 통신만을 지원한다.
아작스에 있어서 get보다 post가 좋은 점들:
1. 큰 데이터 전송에 더 알맞다.
2. 특수문자등이 들어가 데이터 전송에 알맞다.
3. 파일이나 db를 업데이트 할 때 알맞다.(더 안정성이 높기 때문이다.)

아작스의 비동기 전송과 동기 전송의 차이
비동기 방식은 일단 보내 놓고 기다리는 방식이라서 시간 절약이된다.
그동안 브라우저는 다른 작업을 진행할 수 있게 된다.
동기식으로 할 경우 서버에서 응답이 올 때까지 프리즈 된다.

아작스 사용의 기본적인 형태
function loadDoc() {
  var xhttp = new XMLHttpRequest(); // 오브젝트 생성
  xhttp.onreadystatechange = function() { // readyState가 변할 때마다 실행되는 이벤트핸들러다.
    if (this.readyState == 4 && this.status == 200) { // 요청이 성공적으로 완료됐을 ture다.
      document.getElementById("demo").innerHTML = this.responseText; // 응답 텍스트로 할 일을 정의한다.
      this.abort(); // 모든 절차가 끝나면 연결을 종료한다.
    }
  };
  xhttp.open("GET", "demo_get.asp", true); // 메소드(get/post), url, 비동기/동기(true/false)
  xhttp.send(); // 실질적으로 요청을 보내는 메소드다.
}

반복된 요청에 캐시된 데이터가 로드 된다면 이렇게 해라.
xhttp.open("GET", "demo_get.asp?t=" + Math.random(), true); //url을 바꿀 수 있어 캐시된 결과가 나오지 않는다.

 XMLHttpRequest 오브젝트의 생성
new XMLHttpRequest()
기본적으로 XMLHttpRequest 객체 하나당 한번의 통신을 하는 것이다.
추가적으로 통신을 할 때 마다 객체는 새로 생성되어야 한다.

open(method, url, async) 메소드 분석
1. method
'get'방식의 경우 url 파라미터에 데이트를 추가하여 전송한다.
'post' 방식의 경우 url 파라미터를 이용할 수도 있지만 다음과 같은 방법을 쓸 수 있다.
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send("fname=Henry&lname=Ford");
다음과 같이 정의한 헤더를 포함 시켜 파라미터를 따로 분리할 수 있다.

**정보기술에서 헤더(header)는 저장되거나 전송되는 데이터 블록의 맨앞에 위치한 보충 데이터를 가리킨다.
데이터 전송에서 헤더를 따르는 데이터는 페이로드(payload), 바디(body)로 불리기도 한다.
헤더 구성은 구문 분석을 위하여 뚜렷하고 모호하지 않은 규격이나 포맷을 따라야 한다.

2. async
비동기 방식(true)과 동기 방식(false)의 구현방법 차이
비동기 방식은 위에서 보듯이 onreadystatechange 이벤트핸들러를 이용하면 된다.
동기시 방식은 onreadystatechange 이벤트핸들러를 사용하지 않는다. 
어차피 모든 전송이 종료될 때까지 프리즈이기 때문에 필요가 없는 것이다.(대신 비효율적이다.)
function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "ajax_info.txt", false);
  xhttp.send();
  document.getElementById("demo").innerHTML = xhttp.responseText;
  xhttp.abort();
}

3. onreadystatechange 이벤트 핸들러
이 핸들러는 readyState 값에 따라 총 5번 작동된다.
readyState 는 다음과 같은 총 5단계의 상태를 갖는다.
Holds the status of the XMLHttpRequest. 
0: request not initialized 
1: server connection established
2: request received 
3: processing request 
4: request finished and response is ready
위에서 보듯이 4일 경우가 요청후 응답을 받은 시점이다.
1, 2, 3, 4 단계에서 각각 status 값을 갖는다.
status 값이 200인 경우가 정상적으로 작동된 경우다.
4 단계의 status 값이 200일 경우가 responseText 를 가지고 동작을 실행할 시점인 것이다.
따라서 일반적으로 다음과 같은 구조를 갖는다.
xhttp.onreadystatechange = function()
{
	if (this.readyState == 4 && this.status == 200)
	{
		xhttp.responseText //얘를 가지고 적절한 동작을 함
	}
}

4. 응답을 받는 방법은 두가지가 있다.
responseText //단순히 문자열로
responseXML //xml로 받을 경우 dom방식으로 접근하여 파싱할 수 있다.
xmlDoc = xhttp.responseXML;
txt = "";
x = xmlDoc.getElementsByTagName("ARTIST"); //텍스트로 받았다면 dom으로 접근할 수 없다.
for (i = 0; i < x.length; i++) {
  txt += x[i].childNodes[0].nodeValue + "<br>";
  }
document.getElementById("demo").innerHTML = txt;

5. 응답에서 해더 내용도 접근할 수 있다.
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    this.getAllResponseHeaders(); // 모든 헤더 정보를 포함한다.
  }
};
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    this.getResponseHeader("Last-Modified"); // 특정 헤더만 골라 올 수 있다.
  }
};

json이란?
JavaScript Object Notation의 약자다.
즉, 자바스크립트 오브젝트 표기법이다.
위에서 봤다시피 자바스크립의 오브젝트를 정의하는 문법에서 따온 표기법이다.

var aa = 
	{"employees":
	[
	{"firstName":"John", "lastName":"Doe"},
	{"firstName":"Anna", "lastName":"Smith"},
	{"firstName":"Peter", "lastName":"Jones"}
	]}
alert(aa.employees[0].firstName); // John

유일한 차이점은 json은 '문자열'이라는 것이다.
var text = '{"name":"John Johnson","street":"Oslo West 16","phone":"555 1234567"}';
var obj = window.JSON.parse(text);
하지만 위 처럼 window.JSON.parse(); 메소드를 이용해 문자열을 오브젝트로 만들 수 있다.
** parse 하다: 문자열이나 데이터를 원하는 방식으로 가공하는 것

json으로 표기할 수 있는 타입들
정수, 실수
문자열 (단, 무조건 ""(쌍따옴표)를 써야한다!!, 또한 네임(키)은 무조건 쌍따옴표로 묶어야 한다.)
불리언 true, false 로 표현
배열 [](대괄호)로 표현
오브젝트 {}(중괄호로 표현)
그리고 null

josn파일의 확장자는 '.json'이다.

JSON.parse() 가 없는 브라우저를 위해
var txt = '{"employees":[' +
'{"firstName":"John","lastName":"Doe" },' +
'{"firstName":"Anna","lastName":"Smith" },' +
'{"firstName":"Peter","lastName":"Jones" }]}';
var obj = eval ("(" + txt + ")");
위처럼 문자열을 추가해 eval () 함수를 써 된다. 하지만 추천되지는 않는다.

웹 스토리지란?
모던 브라우저들은 대부분 웹스토리지 기능을 제공한다.
쿠키처럼 브라우저에 데이터를 저장하는 기능을 말하는데 차이점이 좀 있다.
웹스토리지의 데이터는 서버에서 접근할 수 없다.
$_COOKIE 등으로 php에서 쿠키에 접근할 수 있었지만 웹스토리지는 불가능하다.
오직 자바스크립트만으로 컨트롤 될 수 있다. (물론 아작스같은 통신으로 빼올 수야 있겠지만...)
웹 스토리지는 크게 window.localStorage 오브젝트와 window.sessionStorage 오브젝트로 컨트롤할 수 있다.
전자는 만기일이 없는 데이터를 저자하고 후자는 브라우저가 닫히면 사라지는 세션 데이터를 저장한다.
두 웹 스토리지 다 개발자도구에서 확인할 수 있다.
데이터를 추가하기 위해선 다음과 같은 문법이 쓰인다.
window.localStorage.setItem('사람', '여자'); // 데이터 저장을 위해 setItem() 메소드를 사용한다.
window.localStorage.getItem('사람'); // '여자'를 리턴한다. 데이터 출력을 위해 getItem() 메소드를 사용한다.
window.localStorage.person = 'female'; // 이런 문법도 지원한다.
window.localStorage.person; // 'female'을 리턴한다.
아래쪽 방법은 키값에 띄어쓰기를 할 수 없다는 단점이 있다.
window.sessionStorage 도 똑같은 방식으로 사용 가능하다.

event 객체
이벤트 핸들링을 할 때 콜백함수의 파라미터에 event 를 넣어주면 콜백함수 내에서 event 객체에 접근할 수 있다.
이벤트리스너를 사용한 방법:
document.getElementsByTagName('input')[0].addEventListener('keyup', function(event){alert(event.keyCode)});
태그 어트리뷰트를 사용한 방법:
<input type="text" size="40" onkeypress="myFunction(event)">
두가지 방법으로 모두 event 오브젝트를 컨트롤 할 수 있다.






