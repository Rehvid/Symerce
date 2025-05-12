import { Swiper, SwiperSlide } from 'swiper/react';
import { Pagination } from 'swiper/modules';

const ProductThumbnailSwiper = ({images}) => {


  //TODO: Add zoom with modal
  return (
    <Swiper
      className="h-[630px]"
      modules={[Pagination]}
      pagination={{
        type: 'bullets',
        clickable: true,
      }}
    >
      {Object.values(images).map((image, key) => (
        <SwiperSlide key={key}>
          <div className="h-[600px] flex items-center justify-center">
            <img
              src={image}
              alt="Thumbnail"
              className="h-full w-full object-cover rounded-lg"
              loading="lazy"
            />
          </div>
        </SwiperSlide>
      ))}

    </Swiper>
  )
}

export default ProductThumbnailSwiper;
