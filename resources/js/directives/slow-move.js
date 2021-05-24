const animate = classes => {

    const animatedScrollObserver = new IntersectionObserver(
        (entries, animatedScrollObserver) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {

                    entry.target.classList.add(...classes);
                    animatedScrollObserver.unobserve(entry.target);
                }
            });
        });

    return animatedScrollObserver;
}

export default {

    bind(el, binding) {
        el.classList.add(...binding.value.beforeClasses);
        animate(binding.value.afterClasses).observe(el);
    }
}