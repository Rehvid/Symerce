import React, { useEffect, useState } from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { normalizeFiles } from '@admin/common/utils/helper';
import { useDropzoneLogicMulti } from '@admin/common/hooks/form/dropzone/useDropzoneLogicMulti';
import Dropzone, { DropzoneVariant } from '@admin/common/components/dropzone/Dropzone';
import { UseFormSetValue } from 'react-hook-form';
import { ProductFormData, ProductImage } from '@admin/modules/product/interfaces/ProductFormData';
import ProductDropzoneThumbnailList from '@admin/modules/product/components/ProductDropzoneThumbnailList';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

interface ProductImagesProps {
    setValue: UseFormSetValue<ProductFormData>;
    formData?: ProductFormData;
}

const ProductImages: React.FC<ProductImagesProps> = ({ formData, setValue }) => {
    const [productImages, setProductImages] = useState<ProductImage[]>([]);
    const maximumFiles = 5;

    useEffect(() => {
        if (formData?.images) {
            const normalizedImages = normalizeFiles(formData?.images);
            setProductImages(normalizedImages as ProductImage[]);
        }
    }, [formData?.images]);

    useEffect(() => {
        setValue('images', productImages);
    }, [productImages]);

    const setDropzoneValue = (newImages: UploadFile[]) => {
        setProductImages(newImages as ProductImage[]);
        setValue('images', newImages as ProductImage[]);
    };

    const { onDrop, errors, removeFile } = useDropzoneLogicMulti({
        setValue: setDropzoneValue,
        value: productImages,
        maxFiles: maximumFiles,
    });

    const setMainThumbnail = (file: ProductImage) => {
        setProductImages((prevProductImages) =>
            prevProductImages.map((productImage) => ({
                ...productImage,
                isThumbnail: productImage.uuid === file.uuid,
            })),
        );
    };

    return (
        <FormSection title="Zdjęcia">
            <div className="border border-gray-100 rounded-lg">
                <Dropzone
                    onDrop={onDrop}
                    errors={errors}
                    containerClasses=" flex gap-5 p-5"
                    variant={DropzoneVariant.Multiple}
                >
                    {productImages.length > 0 && (
                        <ProductDropzoneThumbnailList
                            setMainThumbnail={setMainThumbnail}
                            files={productImages}
                            setFiles={setProductImages}
                            removeFile={removeFile}
                        />
                    )}
                </Dropzone>
            </div>
        </FormSection>
    );
};

export default ProductImages;
