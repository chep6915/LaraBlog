<template>
    <div class="about" >
        <el-container  justify="center">
            <el-header class="header" >
                <!-- <el-button type="warning">我是header</el-button> -->
            </el-header>
            <el-container class="content" >
                <el-main class="main" style="display: flex;justify-content: center;">
                    <el-form  style="width:25vw">
                        <el-form-item label="帳號">
                            <el-input  v-model="form.name"  placeholder="請輸入帳號" clearable />
                        </el-form-item>
                        <el-form-item label="密碼">
                            <el-input v-model="form.pwd"  placeholder="請輸入密碼" clearable show-password/>
                        </el-form-item>
                        
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit"
                                >登入</el-button
                            >
                        </el-form-item>
                    </el-form>
                </el-main>
            </el-container>
        </el-container>
    </div>
</template>

<script>

import { mapGetters } from "vuex";
import { defineComponent, ref ,reactive} from "vue";
// import { Calendar, Search } from '@element-plus/icons'
export default defineComponent({
    name: "login",
    components: {},
    setup() {

        const form = reactive({
            account:null,
            pwd:null
        });
        // const onSubmit = () => {
        //     axios({
        //         method:'post',
        //         url: "http://loveenjoylife.com/api/index/login",
        //         data: {
        //             id:requestUrl
        //         }
        //     })
        // }
        
        
        return {
            radio1: ref("1"),
            radio2: ref("1"),
            radio3: ref("1"),
            radio4: ref("1"),
            form,
            
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
