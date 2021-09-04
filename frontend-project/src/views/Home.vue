<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <HelloWorld msg="Welcome to Your Vue.js App" />
    <el-button type="danger" icon="el-icon-delete" round> 我是 ElButton </el-button>
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from "@/components/HelloWorld.vue";
import { mapGetters } from "vuex";
import { defineComponent, ref } from "vue";
import { ElButton } from "element-plus";

export default defineComponent({
  name: "Home",
  components: {
    HelloWorld,
    ElButton
  },
  setup() {
    return {
      radio1: ref("1"),
      radio2: ref("1"),
      radio3: ref("1"),
      radio4: ref("1"),
    }; // 这里返回的任何内容都可以用于组件的其余部分
  },
  computed: {
    ...mapGetters(["sidebar"]),
  },
  mounted() {
    console.log(this.sidebar);
  },
});
</script>
