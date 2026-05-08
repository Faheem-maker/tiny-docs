<script setup>
import { ref, onMounted } from "vue"
import TypeIt from "typeit"
import hljs from "highlight.js"
import "highlight.js/styles/github-dark.css"

const codeEl = ref(null)
const step = ref(0)

const files = [
{
name: "Controller.php",
language: "php",
code: `
class HomeController
{
    public function index(Request $request)
    {
        return view('home', [
            'message' => 'Hello World'
        ]);
    }
}`
},
{
name: "view.php",
language: "html",
code: `<main class="container">
  <h1>{{ $message }}</h1>

  <p>
    Welcome to your Bolt PHP application.
  </p>
</main>`
}
]

function highlightCurrent() {
const current = files[step.value]

const result = hljs.highlight(current.code, {
language: current.language
})

codeEl.value.innerHTML = result.value
}

function startTyping() {

const current = files[step.value]

codeEl.value.textContent = ""

new TypeIt(codeEl.value, {
speed: 32,
cursor: true,
html: false,
afterComplete: () => {

highlightCurrent()

setTimeout(() => {

step.value++

if (step.value < files.length) {
startTyping()
}

}, 2500)

}
})
.type(current.code)
.go()

}

onMounted(() => {
startTyping()
})
</script>

<template>

<div class="editor">

<div class="editor-header">

<div class="dots">
<span></span>
<span></span>
<span></span>
</div>

<div class="tabs">
<span
v-for="(file, i) in files"
:key="file.name"
:class="{ active: step === i }"
>
{{ file.name }}
</span>
</div>

</div>

<div class="editor-body">
<pre>
<code ref="codeEl"></code>
</pre>
</div>

</div>

</template>

<style scoped>

.editor{
background:#0f1117;
border-radius:14px;
border:1px solid #222;
overflow:hidden;
width:560px;
box-shadow:0 20px 40px rgba(0,0,0,0.35);
}

/* HEADER */

.editor-header{
display:flex;
align-items:center;
gap:20px;
padding:10px 14px;
background:#151823;
border-bottom:1px solid #222;
}

.dots{
display:flex;
gap:6px;
}

.dots span{
width:10px;
height:10px;
border-radius:50%;
display:block;
}

.dots span:nth-child(1){ background:#ff5f56 }
.dots span:nth-child(2){ background:#ffbd2e }
.dots span:nth-child(3){ background:#27c93f }

/* FILE TABS */

.tabs{
display:flex;
gap:14px;
font-size:13px;
font-family:Inter, system-ui, sans-serif;
color:#8b949e;
}

.tabs span{
padding:4px 8px;
border-radius:6px;
}

.tabs span.active{
background:#0f1117;
color:#fff;
}

/* BODY */

.editor-body{
padding:20px;
font-family:"JetBrains Mono", monospace;
font-size:14px;
line-height:1.5;
min-height:300px;
}

pre{
margin:0;
white-space:pre-wrap;
color:#e6edf3;
}

</style>