const button = document.querySelector('.button');

button.addEventListener('mouseover', () => {
    button.animate(
        {
            scale: [1, 1.1]
        },
        {
            duration: 100,
            easing: 'ease',
            fill: 'forwards',
        }
    );
});

button.addEventListener('mouseout', () => {
    button.animate(
        {
            scale: [1.1, 1]
        },
        {
            duration: 100,
            easing: 'ease',
            fill: 'forwards',
        }
    );
});