<template>
  <div class="footer-container">
    
    <div class="footer-navs">

      <ul>
        <li>اتاق های فرار</li>
        <li>
          <a href="/cities">شهرها</a>
        </li>
        <li>
          <a href="/collections">مجموعه ها</a>
        </li>
        <li>
          <a href="/learn">آموزش ها</a>
        </li>
        <li>
          <a href="/genres">جستجوی پیشرفته</a>
        </li>
      </ul>

      <ul>
        <li>Miss Escape</li>
        <li>
          <a href="/about-us">داستان ما</a>
        </li>

        <li>
          <a href="/contact-us">تماس با ما</a>
        </li>
      </ul>
    </div>
    
    <div class="footer-site-information">
      <div class="footer-logo-insta centered-flex">
        <a>
          <img :src="iconPath('logo.svg')" />
        </a>
        <a target = "_blank" href="https://www.instagram.com/miss_escaperoom/" class="cta footer-cta centered-flex">
          <img :src="iconPath('white-instagram.svg')" alt="instagram logo" />
          <span>اینستاگرام</span>
        </a>
      </div>
      <p>طراحی و پیاده سازِی توسط مسیح عیدوی، مصطفی عابدی</p>
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

.footer-logo-insta{
        flex-direction: column;
    border-bottom: 1px dashed var(--text);
    padding-bottom: 1rem;
    width: 15rem;
    margin: 0 auto;
}

.footer-site-information p {
font-size: .6rem;
}
.footer-site-information {
  margin: 2rem auto;
  order: 2;
  text-align: center;
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