<template>
  <div class="footer-container">
    <div class="footer-site-information">
      <div class="footer-logo-insta centered-flex">
        <a>
          <img :src="iconPath('logo.svg')" />
        </a>
        <a class="cta footer-cta centered-flex">
          <img :src="iconPath('white-instagram.svg')" alt="instagram logo" />
          <span>اینستاگرام</span>
        </a>
      </div>
      <p>طراحی و پیاده سازِی توسط مسیح عیدوی، مصطفی عابدی</p>
    </div>

    <div class="footer-navs">
      <ul>
        <li>تهرانی ها</li>
        <li>شمال تهران</li>
        <li>جنوب تهران</li>
        <li>شرق تهران</li>
        <li>غرب تهران</li>
      </ul>

      <ul>
        <li>شهرها</li>
        <li>تهران</li>
        <li>البرز</li>
        <li>یزد</li>
        <li>همدان</li>
        <li>کاشان</li>
        <li>شیراز</li>
        <li>مشهد</li>
        <li>کرمانشاه</li>
      </ul>

      <ul>
        <li>Miss Escape</li>
        <li>داستان ما</li>
        <li>تماس با ما</li>
        <li>درباره ما</li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },

  methods: {
    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },
};
</script>

<style scoped>
.footer-container {
  display: flex;
  flex-wrap: wrap;
}

.footer-logo-insta{
    flex-direction: column;
    border-bottom: 1px dashed var(--text);
    padding-bottom: 1rem;
}

.footer-navs {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  flex: 0 1 22rem;
  order: 1;
}

.footer-site-information p {
font-size: .6rem;
}
.footer-site-information {
  margin: 0 auto;
  order: 2;
}

.footer-cta img {
  margin-right: 1rem;
  width: 1.5rem;
}

.footer-navs ul li:not(:first-child):hover {
  transform: translateX(-3px);
}

.footer-navs ul li:not(:first-child) {
  transition: all 200ms;
  cursor: pointer;
}

.footer-navs ul li:first-child {
  font-weight: bold;
}

.footer-navs ul {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: flex-end;
  flex: 0 0 7rem;
  padding: 0;
  font-size: 0.9rem;
  line-height: 2.2;
}
</style>