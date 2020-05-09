<template>
  <v-container class="account d-flex flex-column justify-space-between" fluid>
    <v-row align="center" justify="center" column>
      <v-col cols="12" class="d-flex flex-column justify-center align-center">
        <ValidationObserver v-slot="{ invalid, passes }" class="form">
          <v-card flat class="pb-9">
            <v-toolbar flat height="90">
              <v-spacer/>
              <v-toolbar-title class="form-title">Đăng nhập</v-toolbar-title>
              <v-spacer/>
            </v-toolbar>
            <v-card-text class="form-content">
              <v-form @submit.prevent="passes(submit)" @keyup.native.enter="passes(submit)">
                <ValidationProvider
                    name="Email"
                    rules="required|email"
                    v-slot="{ errors }"
                >
                  <v-text-field
                      name="username"
                      v-model="formData.username"
                      type="text"
                      :messages="errors[0] || ''"
                      :error="!!errors.length"
                  >
                    <template v-slot:label>
                      <div class="form-input-label">
                        Tên đăng nhập <sup class="red--text">*</sup>
                      </div>
                    </template>
                  </v-text-field>
                </ValidationProvider>
                <ValidationProvider
                    name="Mật khẩu"
                    rules="required"
                    v-slot="{ errors }"
                >
                  <v-text-field
                      id="password"
                      v-model="formData.password"
                      name="password"
                      type="password"
                      :messages="errors[0] || ''"
                      :error="!!errors.length"
                  >
                    <template v-slot:label>
                      <div class="form-input-label"> Mật khẩu <sup class="red--text">*</sup></div>
                    </template>
                  </v-text-field>
                </ValidationProvider>
              </v-form>
            </v-card-text>
            <v-card-actions class="form-action d-flex flex-column">
              <v-btn
                  height="40"
                  depressed
                  block
                  :disabled="invalid"
                  :loading="submiting"
                  color="primary"
                  @click="passes(submit)"
              >
                Đăng nhập
              </v-btn>
            </v-card-actions>
          </v-card>
        </ValidationObserver>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import {mapActions} from 'vuex'

  export default {
    name: 'Login',
    data () {
      return {
        submiting: false,
        formData: {
          username: '',
          password: '',
        },
      }
    },
    methods: {
      ...mapActions('auth', ['login']),
      async submit() {
        this.submiting = true
        await this.login(this.formData)
        this.submiting = false
      },
    }
  }
</script>

<style lang="css" scoped>
  @import url("https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap");

  .account {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
    url(../assets/images/background_login.jpg) no-repeat center center fixed;
    background-size: cover;
    height: 100%;
  }

  .form {
    width: 470px;
  }

  .form-title {
    font-family: "Roboto Slab", serif;
    font-weight: bold;
    font-size: 24px;
    text-transform: uppercase;
  }

  .form-content {
    padding: 0 40px;
  }

  .form-input-label {
    font-size: 14px;
  }

  .form-action {
    padding: 18px 40px 0 40px;
    width: 100%;
  }

  .form-action-link a {
    color: #6398ff;
    text-decoration: none;
  }

  @media (max-width: 600px) {
    .form {
      width: 100%;
    }
  }

  @media (min-width: 1600px) {
    .account {
      height: 900px;
    }
  }
</style>

