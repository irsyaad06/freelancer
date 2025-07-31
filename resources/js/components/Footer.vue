<template>
  

<footer class="bg-white z-50">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
              <a href="/" class="flex items-center">
                  <img v-if="setting && setting.logo_web" :src="setting.logo_web" class="h-8 me-3" :alt="setting.nama_web" />
                  <span class="self-center text-2xl font-semibold whitespace-nowrap ">{{ setting ? setting.nama_web : "FindLancer" }}</span>
              </a>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
          
              <div v-if="setting && (setting.facebook_web || setting.instagram_web)">
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase ">Follow us</h2>
                  <ul class="text-gray-500  font-medium">
                      <li v-if="setting.facebook_web" class="mb-4">
                          <a :href="setting.facebook_web" target="_blank" class="hover:underline">Facebook</a>
                      </li>
                      <li v-if="setting.instagram_web">
                          <a :href="setting.instagram_web" target="_blank" class="hover:underline">Instagram</a>
                      </li>
                  </ul>
              </div>
              <div v-if="setting && (setting.email_web || setting.twitter_web)">
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Kontak</h2>
                  <ul class="text-gray-500 font-medium">
                      <li v-if="setting.email_web" class="mb-4">
                          <a :href="'mailto:' + setting.email_web" class="hover:underline">Email</a>
                      </li>
                      <li v-if="setting.twitter_web">
                          <a :href="setting.twitter_web" target="_blank" class="hover:underline">X</a>
                      </li>
                  </ul>
              </div>
            
          </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto  lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center">© {{ new Date().getFullYear() }} <a href="/" class="hover:underline">{{ setting ? setting.nama_web : "FindLancer" }}™</a>. All Rights Reserved.
          </span>
          <div class="flex mt-4 sm:justify-center sm:mt-0" v-if="setting">
              <a v-if="setting.facebook_web" :href="setting.facebook_web" target="_blank" class="text-gray-500 hover:text-gray-900 ">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                        <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                    </svg>
                  <span class="sr-only">Facebook page</span>
              </a>
              <a v-if="setting.instagram_web" :href="setting.instagram_web" target="_blank" class="text-gray-500 hover:text-gray-900  ms-5">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0Zm3.233 6.7a.833.833 0 0 1 .833.833v5.062a.833.833 0 0 1-.833.834H6.767a.833.833 0 0 1-.833-.834V7.533a.833.833 0 0 1 .833-.833h6.466ZM10 8.167a1.833 1.833 0 1 0 0 3.667 1.833 1.833 0 0 0 0-3.667Z" clip-rule="evenodd"/>
                    <path fill-rule="evenodd" d="M12.947 10a2.947 2.947 0 1 1-5.893 0 2.947 2.947 0 0 1 5.893 0ZM13.8 6.7a.8.8 0 1 1-1.6 0 .8.8 0 0 1 1.6 0Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="sr-only">Instagram page</span>
              </a>
              <a v-if="setting.email_web" :href="'mailto:' + setting.email_web" class="text-gray-500 hover:text-gray-900  ms-5">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                      <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                      <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                  </svg>
                  <span class="sr-only">Email</span>
              </a>
              <a v-if="setting.twitter_web" :href="setting.twitter_web" target="_blank" class="text-gray-500 hover:text-gray-900  ms-5">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937L6.934 9.128 1.5 15.25H.046l5.603-6.438L0 .75h5.063l4.393 5.394L12.6.75ZM11.437 13.5h1.216L4.35 2.165H3.065l8.372 11.335Z"/>
                  </svg>
                  <span class="sr-only">X page</span>
              </a>
          </div>
      </div>
    </div>
</footer>

</template>

<script setup>
import { onMounted, computed } from "vue";
import { useSettingStore } from "../stores/settingStore";

const settingStore = useSettingStore();
const setting = computed(() => settingStore.setting);

onMounted(() => {
    settingStore.fetchSetting();
});
</script>
