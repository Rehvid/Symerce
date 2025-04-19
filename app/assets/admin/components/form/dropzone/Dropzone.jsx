import { useDropzone } from 'react-dropzone';
import PhotosIcon from '@/images/icons/photos.svg';

const Dropzone = ({ onDrop, errors, variant = 'sideColumn', containerClasses = '', children }) => {
    const { getRootProps, getInputProps } = useDropzone({ onDrop });
    const variants = {
        sideColumn: `dropzone max-w-full  min-h-[130px] rounded-md `,
        avatar: 'rounded-full h-40 w-40',
    };

    return (
        <section className={`container ${containerClasses}`}>
            <div
                {...getRootProps({
                    className: `${variants[variant] ?? ''} flex flex-col gap-2 px-4 py-2 justify-center items-center border border-dashed ${errors && errors.message ? 'border-red-500 hover:border-red-700 hover:border-2' : 'border-gray-300 hover:border-primary-stronger'} hover:scale-[105%] transition-all cursor-pointer`,
                })}
            >
                <div>
                    <PhotosIcon />
                </div>
                <input {...getInputProps()} />
                <p className="text-center mt-1 text-xs">
                    <span className="text-gray-800">Drop your image here, or </span>
                    <span className="text-primary">Click to browse</span>
                </p>
            </div>
            {errors && errors.message && <p className="mt-2 mb-2 pl-2 text-sm text-red-600">{errors.message}</p>}
            {children}
        </section>
    );
};
export default Dropzone;
