import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import Description from '@admin/common/components/Description';
import { ProductFormContext } from '@admin/modules/product/interfaces/ProductFormContext';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';

interface ProductLogisticsProps {
    control: Control<ProductFormData>;
    fieldErrors: FieldErrors<ProductFormData>;
    register: UseFormRegister<ProductFormData>;
    formContext?: ProductFormContext;
}

const ProductSeo: React.FC<ProductLogisticsProps> = ({ control, fieldErrors, formContext, register }) => {
    return (
        <FormSection title="SEO">
            <FormGroup
                label={<InputLabel label="Przyjazny URL" htmlFor="slug" />}
                description={<Description>Automacznie generowany z nazwy, jeżeli nic nie zostanie podane.</Description>}
            >
                <InputField
                    type="text"
                    id="slug"
                    hasError={!!fieldErrors?.slug}
                    errorMessage={fieldErrors?.slug?.message}
                    {...register('slug')}
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Meta tytuł" htmlFor="metaTitle" />}>
                <InputField
                    type="text"
                    id="metaTitle"
                    hasError={!!fieldErrors?.metaTitle}
                    errorMessage={fieldErrors?.metaTitle?.message}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('metaTitle')}
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Meta opis" htmlFor="metaDescription" />}>
                <textarea
                    {...register('metaDescription')}
                    className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light"
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Tagi" htmlFor="tags" />}>
                <ControlledReactSelect
                    name="tags"
                    control={control}
                    options={formContext?.availableTags || []}
                    isMulti={true}
                />
            </FormGroup>
        </FormSection>
    );
};

export default ProductSeo;
