import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination } from 'swiper/modules';
import PlaceholderImage from '@/images/placeholder-image.png';
import Heading from '@/admin/components/common/Heading';

const CategoryShowSwiper = ({items}) => {

  const renderImage = (image, name) => {

    if (!image) {
      return (
        <div className="w-full pb-[100%] relative">
          <img
            className="absolute inset-0 w-full h-full object-cover rounded-xl"
            src={PlaceholderImage}
            alt={`Placeholder Image - ${name}`}
            loading="lazy"
          />
        </div>
      )
    }

    return (
      <div className="w-full pb-[100%] relative">
        <img
          className="absolute inset-0 w-full h-full object-cover rounded-xl"
          src={image}
          alt={`Image - ${name}`}
          loading="lazy"
        />
      </div>
    )
  }

  return (
      <Swiper
        navigation
        pagination={{
          type: 'progressbar',
        }}
        spaceBetween={32}
        modules={[Navigation, Pagination]}
        slidesPerView={1}
        className="max-h-[300px]"
        breakpoints={{
          640: {
            slidesPerView: 2,
          },
          768: {
            slidesPerView: 3,
          },
          1024: {
            slidesPerView: 6,
          },
        }}
      >
        {items.map((item, key) => (
          <SwiperSlide key={key}>
            <div className="px-2 py-5 w-full flex">
              <a
                href={item.href}
                className="flex flex-col border border-gray-200 p-4 transition-all duration-300 rounded-xl hover:shadow-lg w-full"
              >
                <div className="flex flex-col justify-between h-full gap-3">
                  {renderImage(item.image, item.name)}
                  <Heading
                    level="h5"
                    additionalClassNames="text-[#3d4750] transition-all duration-300 hover:text-[#6c7fd8] line-clamp-2 min-h-[48px] flex items-center"
                  >
                    {item.name}
                  </Heading>
                </div>
              </a>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>
  )
}

export default CategoryShowSwiper;
