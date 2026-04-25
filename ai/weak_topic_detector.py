import numpy as np

class WeakTopicDetector:
    def analyze_performance(self, quiz_history):
        topic_scores = {}
        
        for quiz in quiz_history:
            topic = quiz['topic']
            accuracy = quiz['correct'] / quiz['total'] if quiz['total'] > 0 else 0
            
            if topic not in topic_scores:
                topic_scores[topic] = []
            topic_scores[topic].append(accuracy)
        
        weak_topics = []
        strong_topics = []
        recommendations = []
        
        for topic, scores in topic_scores.items():
            avg_score = np.mean(scores)
            if avg_score < 0.6:
                weak_topics.append(topic)
                recommendations.append(f"Focus more on {topic} - your accuracy is {avg_score*100:.0f}%")
            elif avg_score > 0.85:
                strong_topics.append(topic)
        
        if weak_topics:
            main_recommendation = f"Priority: Master {weak_topics[0]} first, then move to other weak areas."
        else:
            main_recommendation = "Keep up the great work! Start practicing mock tests."
        
        return {
            'weak_topics': weak_topics,
            'strong_topics': strong_topics,
            'recommendation': main_recommendation,
            'detailed_scores': {t: round(np.mean(s), 2) for t, s in topic_scores.items()}
        }