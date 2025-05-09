import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import { Controller } from 'react-hook-form';
import Textarea from '@/admin/components/form/controls/Textarea';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import { normalizeFiles } from '@/admin/utils/helper';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import Heading from '@/admin/components/common/Heading';
import { useEffect, useState } from 'react';
import ProductDropzoneThumbnail from '@/admin/features/product/components/ProductDropzoneThumbnail';
import { useData } from '@/admin/hooks/useData';
import CurrencyIcon from '@/admin/components/common/CurrencyIcon';
import NumberIcon from '@/images/icons/number.svg';
import LabelNameIcon from '@/images/icons/label-name.svg';

const ProductFormMainColumn = ({ register, fieldErrors, control, formData, setValue }) => {
    const { currency } = useData();
    const [productImages, setProductImages] = useState([]);
    const [thumbnail, setThumbnail] = useState(null);

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

    const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, null, productImages, 5);

    const setMainThumbnail = (file) => {
        setThumbnail(file);
        setValue('thumbnail', file);
    };

    return (
        <>
            <Input
                {...register('name', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
                type="text"
                id="name"
                label="Nazwa"
                hasError={!!fieldErrors?.name}
                errorMessage={fieldErrors?.name?.message}
                isRequired
                icon={<LabelNameIcon className="text-gray-500 w-[24px] h-[24px]" />}
            />

            <div>
                <Heading level="h4">
                    <span className="flex items-center mb-2">Zdjęcia </span>
                </Heading>
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
            </div>

            <Input
                {...register('slug')}
                type="text"
                id="slug"
                label="Przyjazny url"
                hasError={!!fieldErrors?.slug}
                errorMessage={fieldErrors?.slug?.message}
            />

            <Controller
                name="description"
                control={control}
                defaultValue=""
                render={({ field }) => <Textarea value={field.value} onChange={field.onChange} title="Opis" />}
            />

            <Input
                {...register('regularPrice', {
                    ...validationRules.required(),
                    ...validationRules.numeric(currency.roundingPrecision),
                })}
                type="text"
                id="regular-price"
                label="Cena regularna"
                hasError={!!fieldErrors?.regularPrice}
                errorMessage={fieldErrors?.regularPrice?.message}
                isRequired
                icon={<CurrencyIcon className="w-[24px] h-[24px]" />}
            />

            <Input
                {...register('discountPrice', {
                    ...validationRules.numeric(currency.roundingPrecision),
                })}
                type="text"
                id="discountPrice"
                label="Cena promocyjna"
                hasError={!!fieldErrors?.discountPrice}
                errorMessage={fieldErrors?.discountPrice?.message}
                icon={<CurrencyIcon className="w-[24px] h-[24px]" />}
            />

            <Input
                {...register('quantity', {
                    ...validationRules.required(),
                    ...validationRules.min(0),
                })}
                type="number"
                id="quantity"
                label="Ilość"
                hasError={!!fieldErrors?.quantity}
                errorMessage={fieldErrors?.quantity?.message}
                isRequired
                icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
            />
        </>
    );
};

export default ProductFormMainColumn;
