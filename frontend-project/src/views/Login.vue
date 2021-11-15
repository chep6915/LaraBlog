<template>
    <div class="about">
        <el-container>
            <el-header class="header">
                <el-button type="warning">我是header</el-button>
            </el-header>
            <el-container class="content">

                <el-main class="main">
                    <el-form ref="form" :model="form" label-width="120px">
                        <el-form-item label="Activity name">
                            <el-input v-model="form.name">{{form.name}}</el-input>
                        </el-form-item>

                        <el-form-item label="Instant delivery">
                            <el-switch v-model="form.delivery"></el-switch>
                        </el-form-item>
                        <el-form-item label="Activity type">
                            <el-checkbox-group v-model="form.type">
                                <el-checkbox
                                    label="Online activities"
                                    name="type"
                                ></el-checkbox>
                                <el-checkbox
                                    label="Promotion activities"
                                    name="type"
                                ></el-checkbox>
                                <el-checkbox
                                    label="Offline activities"
                                    name="type"
                                ></el-checkbox>
                                <el-checkbox
                                    label="Simple brand exposure"
                                    name="type"
                                ></el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>
                        <el-form-item label="Resources">
                            <el-radio-group v-model="form.resource">
                                <el-radio label="Sponsor"></el-radio>
                                <el-radio label="Venue"></el-radio>
                            </el-radio-group>
                        </el-form-item>
                        <el-form-item label="Activity form">
                            <el-input
                                v-model="form.desc"
                                type="textarea"
                            ></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit"
                                >Create</el-button
                            >
                            <el-button>Cancel</el-button>
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
export default defineComponent({
    name: "login",
    components: {},
    setup() {
        const form = reactive({
            name: "",
            region: "",
            date1: "",
            date2: "",
            delivery: false,
            type: [],
            resource: "",
            desc: "",
        });
        console.log(`form`, form);
        let onSubmit =ref((params) => {
          console.log(`params`, params)
        }) 
        
        return {
            radio1: ref("1"),
            radio2: ref("1"),
            radio3: ref("1"),
            radio4: ref("1"),
            form,
            onSubmit
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
