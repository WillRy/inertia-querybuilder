"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[70],{7350:(e,t,r)=>{r.d(t,{Z:()=>a});var o=r(3645),n=r.n(o)()((function(e){return e[1]}));n.push([e.id,".layout-publico[data-v-7ffe3c7e]{align-items:center;background-color:var(--cor-principal);display:flex;justify-content:center;min-height:100vh}",""]);const a=n},3418:(e,t,r)=>{r.d(t,{Z:()=>a});var o=r(3645),n=r.n(o)()((function(e){return e[1]}));n.push([e.id,".login-box[data-v-a62fdeb4]{background:#fff;border-radius:4px;box-shadow:0 0 10px rgba(0,0,0,.2);padding:50px 30px;width:360px}.login-box img[data-v-a62fdeb4]{display:block;margin:0 auto 20px}.login-box h3[data-v-a62fdeb4]{color:var(--cor-principal);font-size:30px;font-weight:700;line-height:35px;margin-bottom:30px;text-align:center;text-transform:uppercase}",""]);const a=n},1467:(e,t,r)=>{r.d(t,{Z:()=>a});var o=r(3645),n=r.n(o)()((function(e){return e[1]}));n.push([e.id,".form-group[data-v-6b445170]{margin-bottom:20px}label[data-v-6b445170]{color:#444;display:block;font-size:14px;font-weight:700;margin-bottom:8px;text-transform:uppercase}input[data-v-6b445170]{background:#fff;border:1px solid #ddd;border-radius:4px;box-sizing:border-box;min-height:50px;padding:13px;width:100%}[data-v-6b445170] .errorMessage>div{color:red;margin:3px 0}",""]);const a=n},5828:(e,t,r)=>{r.d(t,{Z:()=>d});var o=r(821),n={class:"layout-publico"};const a={name:"Publico",watch:{"$page.props.flash.success":{deep:!0,handler:function(e){e&&this.$toast.open({message:e,type:"success"})}},"$page.props.flash.error":{deep:!0,handler:function(e){e&&this.$toast.open({message:e,type:"error"})}}}};var l=r(3379),i=r.n(l),s=r(7350),c={insert:"head",singleton:!1};i()(s.Z,c);s.Z.locals;const d=(0,r(3744).Z)(a,[["render",function(e,t,r,a,l,i){return(0,o.openBlock)(),(0,o.createElementBlock)("div",n,[(0,o.renderSlot)(e.$slots,"default",{},void 0,!0)])}],["__scopeId","data-v-7ffe3c7e"]])},70:(e,t,r)=>{r.r(t),r.d(t,{default:()=>y});var o=r(821),n=function(e){return(0,o.pushScopeId)("data-v-a62fdeb4"),e=e(),(0,o.popScopeId)(),e},a={class:"login-box"},l=n((function(){return(0,o.createElementVNode)("img",{src:"/img/logo.svg",alt:""},null,-1)})),i=n((function(){return(0,o.createElementVNode)("h3",null,"gympoint",-1)})),s=["disabled"],c=(0,o.createTextVNode)(" Entrar no sistema "),d=(0,o.createTextVNode)(" Cadastrar-se ");var p=r(5828),u=r(7640),m=r(9038);const b={name:"login",components:{BaseInput:u.Z,Link:m.rU},layout:p.Z,props:{errors:Object,exception:String},data:function(){return{login:{email:"",password:""},loading:!1}},methods:{submit:function(){var e=this;this.$inertia.post("/login",this.login,{onStart:function(){e.loading=!0},onFinish:function(){e.loading=!1},onError:function(){e.loading=!1},preserveState:!0})}}};var f=r(3379),g=r.n(f),h=r(3418),v={insert:"head",singleton:!1};g()(h.Z,v);h.Z.locals;const y=(0,r(3744).Z)(b,[["render",function(e,t,r,n,p,u){var m=(0,o.resolveComponent)("BaseInput"),b=(0,o.resolveComponent)("Loader"),f=(0,o.resolveComponent)("Link");return(0,o.openBlock)(),(0,o.createElementBlock)("div",a,[l,i,(0,o.createElementVNode)("form",{onSubmit:t[2]||(t[2]=(0,o.withModifiers)((function(){return u.submit&&u.submit.apply(u,arguments)}),["prevent"]))},[(0,o.createVNode)(m,{label:"seu e-mail",type:"email",placeholder:"exemplo@exemplo.com",modelValue:p.login.email,"onUpdate:modelValue":t[0]||(t[0]=function(e){return p.login.email=e}),class:(0,o.normalizeClass)({error:r.errors.email}),error:r.errors.email},null,8,["modelValue","class","error"]),(0,o.createVNode)(m,{label:"sua senha",type:"password",placeholder:"******",modelValue:p.login.password,"onUpdate:modelValue":t[1]||(t[1]=function(e){return p.login.password=e}),class:(0,o.normalizeClass)({error:r.errors.password}),error:r.errors.password},null,8,["modelValue","class","error"]),(0,o.createElementVNode)("button",{class:"btn btn-full btn-primary",type:"submit",disabled:p.loading},[p.loading?((0,o.openBlock)(),(0,o.createBlock)(b,{key:0,width:"20px",height:"20px"})):(0,o.createCommentVNode)("",!0),c],8,s),(0,o.createVNode)(f,{href:"/register",class:"link-btn link-btn-primary link-btn-center"},{default:(0,o.withCtx)((function(){return[d]})),_:1})],32)])}],["__scopeId","data-v-a62fdeb4"]])},7640:(e,t,r)=>{r.d(t,{Z:()=>f});var o=r(821),n=["for"],a=["value"],l={key:1,class:"errorMessage"};function i(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,o)}return r}function s(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?i(Object(r),!0).forEach((function(t){c(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):i(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function c(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const d={name:"BaseInput",inheritAttrs:!1,props:{label:{type:String,default:""},modelValue:[String,Number],mb:{default:"20px"},width:{default:"auto"},error:{type:String}},computed:{attrs:function(){return s(s({},this.$attrs),{},{input:this.updateValue})}},methods:{updateValue:function(e){this.$emit("update:modelValue",e.target.value)}}};var p=r(3379),u=r.n(p),m=r(1467),b={insert:"head",singleton:!1};u()(m.Z,b);m.Z.locals;const f=(0,r(3744).Z)(d,[["render",function(e,t,r,i,s,c){return(0,o.openBlock)(),(0,o.createElementBlock)("div",{class:"form-group",style:(0,o.normalizeStyle)({"margin-bottom":r.mb,width:r.width})},[r.label?((0,o.openBlock)(),(0,o.createElementBlock)("label",{key:0,for:e.$attrs.id},(0,o.toDisplayString)(r.label),9,n)):(0,o.createCommentVNode)("",!0),(0,o.createElementVNode)("input",(0,o.mergeProps)({type:"text",value:r.modelValue,onInput:t[0]||(t[0]=function(){return c.updateValue&&c.updateValue.apply(c,arguments)})},c.attrs),null,16,a),r.error||e.$slots.error?((0,o.openBlock)(),(0,o.createElementBlock)("div",l,[(0,o.createElementVNode)("div",null,(0,o.toDisplayString)(r.error),1),(0,o.renderSlot)(e.$slots,"error",{},void 0,!0)])):(0,o.createCommentVNode)("",!0)],4)}],["__scopeId","data-v-6b445170"]])}}]);