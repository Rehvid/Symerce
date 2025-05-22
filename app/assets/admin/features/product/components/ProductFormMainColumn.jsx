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
import Switch from '@/admin/components/form/controls/Switch';
import DatePicker from 'react-datepicker';
import Select from '@/admin/components/form/controls/Select';


const ProductFormMainColumn = ({ register, fieldErrors, control, formData, setValue, watch }) => {
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

            <Switch label="Dodaj promocje" {...register('promotionIsActive')} />

            {watch().promotionIsActive && (
              <div className="mt-3 flex flex-col w-full gap-[2rem]">
                <Heading level="h3">Promocja</Heading>
                  <Controller
                    name="promotionDateRange"
                    control={control}
                    defaultValue={[null, null]}
                    rules={{
                      validate: (promotionDateRange) => {
                        const [start, end] = promotionDateRange;
                        if (!start || !end) {
                          return "Musisz wybrać oba terminy";
                        }
                        return true;
                      }
                    }}
                    render={({ field }) => (
                      <div className="w-full">
                        <Heading level="h4" additionalClassNames={`mb-2 ${!!fieldErrors?.promotionDateRange ? ' text-red-900' : ''}`}>
                          Data obowiązywania promocji
                          <span className="pl-1 text-red-500">*</span>
                        </Heading>
                        <DatePicker
                          selectsRange
                          startDate={field.value[0]}
                          endDate={field.value[1]}
                          placeholderText="Wybierz datę"
                          onChange={(date) => field.onChange(date)}
                          className={`
                            w-full h-[46px] rounded-lg border border-gray-300 py-2.5 pl-[16px] pr-[60px] text-sm text-gray-800 transition-all 
                            ${!!fieldErrors?.promotionDateRange 
                              ? 'border-red-500 text-red-900 focus:border-1 focus:outline-hidden focus:ring-red-100'
                              : 'focus:border-primary focus:border-1 focus:outline-hidden  focus:ring-primary-light'
                            }
                           
                          `}
                        />
                        {!!fieldErrors?.promotionDateRange && <p className="mt-2 pl-2 text-sm text-red-600">{fieldErrors?.promotionDateRange?.message}</p>}
                      </div>
                    )}
                  />
                <Controller
                  name="promotionReductionType"
                  control={control}
                  defaultValue={null}
                  rules={{
                    ...validationRules.required(),
                  }}
                  render={({ field }) => (
                    <div>
                      <Select
                        label="Typ Promocji"
                        options={formData?.promotionTypes || []}
                        selected={field.value}
                        onChange={(value) => {
                          field.onChange(value);
                        }}
                        isRequired
                        hasError={!!fieldErrors?.promotionReductionType}
                        errorMessage={fieldErrors?.promotionReductionType?.message}
                      />
                    </div>
                  )}
                />
                <Input
                  {...register('promotionReduction', {
                    ...validationRules.required(),
                    ...validationRules.min(0),
                  })}
                  type="number"
                  id="promotionReduction"
                  label="Redukcja"
                  hasError={!!fieldErrors?.promotionReduction}
                  errorMessage={fieldErrors?.promotionReduction?.message}
                  isRequired
                  icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
                />
              </div>
            )}
        </>
    );
};

export default ProductFormMainColumn;
