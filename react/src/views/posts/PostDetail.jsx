import { useParams, useNavigate, Link } from "react-router-dom";
import { useEffect, useState } from "react";
import axiosClient from "../../axios-client.js";

export default function PostDetail() {
    const { id } = useParams();
    const navigate = useNavigate();

    const [post, setPost] = useState({
        id: null,
        title: '',
        description: '',
        user_id: '',
        image: '',
        created_at: '',
        updated_at: '',
    });

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (!id) return;

        setLoading(true);
        setError(null);

        axiosClient
            .get(`/posts/${id}`)
            .then(({ data }) => {
                setPost(data);
            })
            .catch(() => {
                setError('Failed to load post.');
            })
            .finally(() => {
                setLoading(false);
            });
    }, [id]);

    const formatDate = (date) => {
        if (!date) return '';
        return new Date(date).toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });
    };

    if (loading) {
        return <p>Loading post...</p>;
    }

    if (error) {
        return <p>{error}</p>;
    }

    return (
        <div className="post-detail">
            <Link className="btn-back" to="/posts">Posts</Link>
            <h1>{post.title}</h1>

            <div className="post-meta">
                <small>
                    Created: {post.created_at}
                    {post.updated_at && post.updated_at !== post.created_at && (
                        <> · Updated: {post.updated_at}</>
                    )}
                </small>
            </div>

            <p className="post-description">
                {post.description}
            </p>

            {post.image && (
                <div className="post-image">
                    <img
                        src={`http://localhost:8000/storage/${post.image}`}
                        alt={post.title}
                        width="500"
                    />
                </div>
            )}
        </div>
    );
}
