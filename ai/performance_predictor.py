import numpy as np

class PerformancePredictor:
    def predict_score(self, study_data):
        avg_hours = study_data.get('avg_daily_hours', 4)
        topics_covered = study_data.get('topics_covered', 0)
        total_topics = study_data.get('total_topics', 10)
        days_left = study_data.get('days_left', 100)
        
        coverage_percent = (topics_covered / total_topics) * 100 if total_topics > 0 else 0
        
        # Simple prediction model
        predicted_score = min(100, 30 + (avg_hours * 3) + (coverage_percent * 0.5))
        
        # Confidence based on data available
        confidence = min(95, 50 + (days_left / 2))
        
        if avg_hours < 4:
            recommendation = f"Increase daily study to 6-7 hours for better results"
        elif coverage_percent < 50:
            recommendation = f"Focus on completing more topics, especially high-weightage ones"
        else:
            recommendation = f"Excellent progress! Start solving previous year papers"
        
        return {
            'predicted_score': round(predicted_score, 1),
            'confidence': round(confidence, 1),
            'recommendation': recommendation
        }