import DOMPurify from 'quill/formats/link';

const DescriptionTab = ({content}) => (
  <div className="break-all" dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(content) }}></div>
)

export default DescriptionTab;
