const toggleHeader = document.querySelector('.toggle-header')
const dropdownContent = document.querySelector('.dropdown-content')
const arrow = document.querySelector('.arrow')

toggleHeader.addEventListener('click', () => {
	dropdownContent.style.display =
		dropdownContent.style.display === 'block' ? 'none' : 'block'
	arrow.classList.toggle('rotated')
})

const levels = document.querySelectorAll('.level')

levels.forEach(level => {
	const levelHeader = level.querySelector('.level-header')
	const levelDetails = level.querySelector('.level-details')
	const levelArrow = level.querySelector('.level-arrow')

	levelHeader.addEventListener('click', () => {
		levelDetails.style.display =
			levelDetails.style.display === 'block' ? 'none' : 'block'
		levelArrow.classList.toggle('rotated')
	})
})

document
	.getElementById('openYandexMapButton')
	.addEventListener('click', function () {
		window.location.href =
			'https://yandex.ru/maps/63/irkutsk/house/mikrorayon_yubileyny_49_1/ZUkCaARgSkIBWUJvYWJzc31gbAs=/?ll=104.304685%2C52.221188&z=18.83' // Перенаправление на Яндекс.Карты
	})
