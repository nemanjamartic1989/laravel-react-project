import { useNavigate, useParams } from "react-router-dom";
import { useEffect, useState } from "react";
import axiosClient from "../../axios-client.js";
import { toast, ToastContainer } from "react-toastify";

export default function PostForm() {
    const navigate = useNavigate();
    const { id } = useParams();

    const [post, setPost] = useState({
        id: null,
        title: '',
        description: '',
        user_id: '',
        image: '',
    });
    const [selectedFile, setSelectedFile] = useState(null);
    const [errors, setErrors] = useState(null);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (!id) return;

        setLoading(true);
        axiosClient.get(`/posts/${id}`)
            .then(({ data }) => {
                setLoading(false);
                setPost(data);
            })
            .catch(() => setLoading(false));
    }, [id]);

    const onSubmit = ev => {
        ev.preventDefault();

        const formData = new FormData();
        formData.append("title", post.title || "");
        formData.append("description", post.description || "");
        if (post.user_id) formData.append("user_id", post.user_id);

        if (selectedFile) {
            formData.append('image', selectedFile);
        } else if (post.image) {
            formData.append('image_path', post.image);
        }

        const request = post.id
            ? axiosClient.post(`/posts/${post.id}`, formData, {
                headers: { "Content-Type": "multipart/form-data" },
                params: { _method: 'PUT' }
            })
            : axiosClient.post(`/posts`, formData, {
                headers: { "Content-Type": "multipart/form-data" }
            });

        request.then(() => {
            toast.success(`Post successfully ${post.id ? "updated" : "created"}!`, {
                autoClose: 3000,
                onClose: () => navigate('/posts'),
            });
        })
        .catch(err => {
            const response = err.response;
            if (response && response.status === 422) {
                toast.error('Please fill required fields.');
                setErrors(response.data.errors);
            }
        });
    };

    return (
        <>
            <h1>{post.id ? `Update Post: ${post.title}` : "New Post"}</h1>

            <div className="card animated fadeInDown">
                {loading && <div className="text-center">Loading...</div>}

                {!loading && (
                    <form onSubmit={onSubmit} encType="multipart/form-data">
                        <input
                            type="text"
                            value={post.title}
                            onChange={ev => setPost({ ...post, title: ev.target.value })}
                            placeholder="Title"
                        />
                        {errors?.title && <span className="error">{errors.title[0]}</span>}

                        <textarea
                            value={post.description}
                            onChange={ev => setPost({ ...post, description: ev.target.value })}
                            placeholder="Description"
                            rows="5"
                            style={{ marginTop: '10px', width: '100%' }}
                        />
                        {errors?.description && <span className="error">{errors.description[0]}</span>}

                        <input
                            type="file"
                            accept="image/*"
                            onChange={ev => setSelectedFile(ev.target.files[0])}
                            style={{ marginTop: '10px' }}
                        />
                        {errors?.image && <span className="error">{errors.image[0]}</span>}

                        { (selectedFile || post.image) && (
                            <div style={{ marginTop: '10px' }}>
                                <img
                                    src={
                                        selectedFile
                                            ? URL.createObjectURL(selectedFile)
                                            : `http://localhost:8000/storage/${post.image}`
                                    }
                                    alt="preview"
                                    width="150"
                                />
                            </div>
                        )}

                        <button className="btn" style={{ marginTop: '10px' }}>Save</button>
                    </form>
                )}
            </div>

            <ToastContainer
                position="top-right"
                autoClose={3000}
                hideProgressBar={false}
            />
        </>
    );
}
