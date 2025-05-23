import React, { useEffect, useState } from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import { normalizeFiles } from '@admin/utils/helper';
import { useDropzoneLogic } from '@admin/hooks/useDropzoneLogic';
import ProductDropzoneThumbnail from '@admin/features/product/components/ProductDropzoneThumbnail';
import Dropzone from '@admin/components/form/dropzone/Dropzone';
import { UseFormSetValue } from 'react-hook-form';
import { ProductFormData } from '@admin/modules/product/components/ProductFormBody';


interface ProductImagesProps {
  setValue: UseFormSetValue<ProductFormData>;
  formData?: ProductFormData;
}

const ProductImages : React.FC<ProductImagesProps> = ({formData, setValue}) => {
  const [productImages, setProductImages] = useState([]);
  const [thumbnail, setThumbnail] = useState(null);
  const maximumFiles = 5;

  useEffect(() => {
    if (formData?.images) {
      const normalizedImages = normalizeFiles(formData?.images);
      setProductImages(normalizedImages);
    }
  }, [formData?.images]);

  const setDropzoneValue = (newImages) => {
    setProductImages(newImages);
    setValue('images', newImages);
  };

  const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, null, productImages, maximumFiles);

  const setMainThumbnail = (file) => {
    setThumbnail(file);
    setValue('thumbnail', file);
  };

  return (
    <FormSection title="Zdjęcia" >
      <Dropzone onDrop={onDrop} errors={errors}>
        {productImages.length > 0 && (
          <div className="flex flex-wrap gap-5 mt-5">
            {productImages.map((file, key) => (
              <ProductDropzoneThumbnail
                key={key}
                index={key}
                file={file}
                removeFile={removeFile}
                setMainThumbnail={setMainThumbnail}
                thumbnail={thumbnail}
              />
            ))}
          </div>
        )}
      </Dropzone>
    </FormSection>
  )
}

export default ProductImages;
